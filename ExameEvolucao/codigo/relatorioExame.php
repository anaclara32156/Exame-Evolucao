<?php
session_start();
require_once "exameCRUD.php";
require_once __DIR__ . '/vendor/autoload.php';

$dadosUsuario = $_SESSION['dadosUsuario'];
$nome = $dadosUsuario['nome'];

date_default_timezone_set('America/Sao_Paulo');

$mpdf = new \Mpdf\Mpdf();
$mpdf->SetDisplayMode("fullpage");

$css = file_get_contents('assets/css/relatorio.css');
$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

$idCliente = $_GET['idCliente'];
$cliente = recuperarClientePorId($idCliente);
$sexoBiologico = $cliente['sexo'];
$exames = listarExamePorCliente($idCliente);

// Agrupar os exames por marcador
$dadosAgrupados = [];
foreach ($exames as $exame) {
    $marcador = $exame['marcador'];
    $dadosAgrupados[$marcador][] = $exame;
}

// Ordenar os exames por data de coleta dentro de cada marcador
foreach ($dadosAgrupados as $marcador => &$exames) {
    usort($exames, function ($a, $b) {
        $dataA = strtotime($a['dataColeta']);
        $dataB = strtotime($b['dataColeta']);
        return $dataA <=> $dataB; // Ordem crescente
    });
}
unset($exames); // Remove a referência para evitar problemas posteriores

$dataEmissao = date("d/m/Y H:i:s");
$html = "
<div id='area01'>
    <img class='figura' src='assets/img/logo.png'>
</div>
<div id='area02'>
    <h1 class='titulo'>Relatório de Exames</h1>
    <p><strong>Cliente:</strong> {$cliente['nome']}</p>
    <p><strong>Profissional:</strong> {$nome}</p>
</div>
<hr>";

$html .= "<div id='area03'>
<hr>";

// Corpo do relatório
foreach ($dadosAgrupados as $marcador => $exames) {
    $idMarcador = $exames[0]['idMarcador'];
    $medida = htmlspecialchars($exames[0]['medida']);

    $medidaCodificada = rawurlencode($medida);

    $valoresReferencia = listarValorPorMarcadorMedidaESexo($idMarcador, $medidaCodificada, $sexoBiologico);

    if (is_string($valoresReferencia)) {
        $valoresReferencia = json_decode($valoresReferencia, true);
    }

    if (is_string($valoresReferencia)) {
        $valoresReferencia = json_decode($valoresReferencia, true);
    }

    $valorMaximo = null;
    $valorMinimo = null;

    // Extrair os valores de referência, se disponíveis
    if (!empty($valoresReferencia) && is_array($valoresReferencia)) {
        foreach ($valoresReferencia as $referencia) {
            if (isset($referencia['emaximo']) && isset($referencia['proprioValor'])) {
                if ($referencia['emaximo'] === 'Sim') {
                    $valorMaximo = $referencia['proprioValor'];
                } elseif ($referencia['emaximo'] === 'Nao') {
                    $valorMinimo = $referencia['proprioValor'];
                }
            }
        }
    }

    // Adicionar o título do marcador e os valores de referência
    $html .= "<h2 style='font-size: 18px;'>{$marcador}</h2>";

    if ($valorMaximo !== null && $valorMinimo !== null) {
        $html .= "<p><strong>Valor de Referência:</strong> Mínimo: {$valorMinimo} {$medida}, Máximo: {$valorMaximo} {$medida}</p>";
    } elseif ($valorMaximo !== null) {
        $html .= "<p><strong>Valor de Referência:</strong> Máximo: {$valorMaximo} {$medida}</p>";
    } elseif ($valorMinimo !== null) {
        $html .= "<p><strong>Valor de Referência:</strong> Mínimo: {$valorMinimo} {$medida}</p>";
    } else {
        $html .= "<p><strong>Valor de Referência:</strong> Não disponível</p>";
    }


    // Adicionar a tabela de exames
    $html .= "<table border='1' width='100%' style='border-collapse: collapse;'>
    <thead>
        <tr>
            <th style='width: 50%;'>Data da Coleta</th>
            <th style='width: 50%;'>Resultado</th>
        </tr>
    </thead>
    <tbody>";

    foreach ($exames as $exame) {
        $dataColeta = (new DateTime($exame['dataColeta']))->format('d/m/Y');
        $resultado = htmlspecialchars($exame['resultado']);

        $html .= "
        <tr>
            <td>{$dataColeta}</td>
            <td>{$resultado} {$medida}</td>
        </tr>";
    }

    $html .= "</tbody></table><br>";
}

$html .= "</div>";

$mpdf->SetHeader("Sistema Exame Evolução | | Emissão: {$dataEmissao}");
$mpdf->SetFooter("{PAGENO} de {nb}");
$mpdf->WriteHTML($html);

$mpdf->Output("relatorio_exames_cliente_{$idCliente}.pdf", "D");
exit();
?>
