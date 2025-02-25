<?php
session_start();
include_once "exameCRUD.php";
$dadosUsuario = $_SESSION['dadosUsuario'];
$idUsuario = $dadosUsuario['id'];

if (isset($_GET['idCliente'])) {
    $idCliente = $_GET['idCliente'];
}

$cliente = recuperarClientePorId($idCliente);

$sexoBiologico = $cliente['sexo'];
$exames = [];

$valorMaximo = null;
$valorMinimo = null;


if (isset($_GET['marcador']) && !empty($_GET['marcador']) && isset($_GET['medida']) && !empty($_GET['medida'])) {
    $marcadorSelecionado = $_GET['marcador'];
    $medidaSelecionada = $_GET['medida'];

    $marcadorCodificado = rawurlencode($marcadorSelecionado);
    $medidaCodificada = rawurlencode($medidaSelecionada);
    
    $exames = listarExamePorMarcadorEClienteEMedida($marcadorCodificado, $idCliente, $medidaCodificada);

    if (!empty($exames) && isset($exames[0]['idMarcador'])) {
        $idMarcador = $exames[0]['idMarcador'];

        $valoresReferencia = listarValorPorMarcadorMedidaESexo($idMarcador, $medidaCodificada, $sexoBiologico);

        if (is_string($valoresReferencia)) {
            $valoresReferencia = json_decode($valoresReferencia, true);
        }

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
    }
}
$examesParaGrafico = [];

// Ordena os exames por data crescente
usort($exames, function ($a, $b) {
    return strtotime($a['dataColeta']) - strtotime($b['dataColeta']);
});

// Prepara os dados para o gráfico, formatando a data para dd-mm-yyyy
foreach ($exames as $exame) {
    $dataFormatada = date('d/m/Y', strtotime($exame['dataColeta']));
    $examesParaGrafico[] = [$dataFormatada, (float)$exame['resultado']];
}
$examesJson = json_encode($examesParaGrafico);


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <title>Comparar Exames</title>
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/estilo.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/datatables.css" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body>
    <?php include_once "menu.php"; ?>
    <h1 class="d-flex justify-content-center align-items-center">
        <a id="btn-left" class="btn btn-left" href="exame.php?idCliente=<?= $idCliente ?>">
            <i class="fa fa-arrow-left"></i> Voltar
        </a>
        <span> Comparar exames</span>
    </h1>
    <span class="nome"><?php echo $cliente['nome']; ?></span>
    <div class="container">
        <hr />
        <div class="content">
            <div class="row form-group">
                <div class="col-md-4">
                    <label style='align-items: center;' for="marcadores">Marcador/Unidade de medida</label>
                    <select class="form-control" id="marcador" name="marcador">
                        <option value="">Selecione</option>
                        <?php
                        $marcadoresUnicos = listarMarcadoresUnicosComUnidade($idCliente); 

                        foreach ($marcadoresUnicos as $marcadorUnico) {
                            $marcador = $marcadorUnico['marcador'];
                            $unidade = $marcadorUnico['medida'];
                            $valorExibido = "{$marcador} ({$unidade})";
                            $selected = ($marcador === $marcadorSelecionado) ? 'selected' : '';
                            echo "<option value='{$marcador}_{$unidade}' {$selected}>{$valorExibido}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row form-group">
    <div class="col-md-8">
        <div id="valoresReferencia">
            <h4>Valores de referência:</h4>
            <?php 
            if ($valorMaximo !== null && $valorMinimo !== null): ?>
                <p> Mínimo: <span id="valorMinimo"><?= $valorMinimo . ' ' . $medidaSelecionada ?></span>, Máximo: <span id="valorMaximo"><?= $valorMaximo . ' ' . $medidaSelecionada ?></span></p>
            <?php elseif ($valorMinimo !== null): ?>
                <p>Mínimo: <span id="valorMinimo"><?= $valorMinimo . ' ' . $medidaSelecionada ?></span></p>
            <?php elseif ($valorMaximo !== null): ?>
                <p>Máximo: <span id="valorMaximo"><?= $valorMaximo . ' ' . $medidaSelecionada ?></span></p>
            <?php else: ?>
                <p>Valores de referência não disponíveis.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

            <div id="curve_chart" style="width: 100%; height: 500px;"></div>
        </div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
    var exames = <?php echo $examesJson; ?>;

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Data');
    data.addColumn('number', 'Resultado');
    data.addColumn('number', 'Valor Máximo'); 
    data.addColumn('number', 'Valor Mínimo');

    var valorMaximo = <?php echo json_encode($valorMaximo); ?>;
    var valorMinimo = <?php echo json_encode($valorMinimo); ?>;

    var escalaMaxima = valorMaximo ? parseFloat(valorMaximo) : null;
    var escalaMinima = valorMinimo ? parseFloat(valorMinimo) : null;

    exames.forEach(function(exame) {
        var resultado = exame[1];
        if (escalaMaxima !== null && resultado > escalaMaxima) {
            escalaMaxima = resultado; 
        }
        if (escalaMinima !== null && resultado < escalaMinima) {
            escalaMinima = resultado; 
        }
        var dataRow = [
            exame[0],
            resultado,
            escalaMaxima !== null ? parseFloat(valorMaximo) : null, 
            escalaMinima !== null ? parseFloat(valorMinimo) : null  
        ];
        data.addRow(dataRow);
    });

    // Adicionar margem à escala
    var margem = 10; 
    if (escalaMaxima !== null) escalaMaxima += margem;
    if (escalaMinima !== null) escalaMinima -= margem;

    var options = {
        title: 'Comparação de Exames',
        legend: { position: 'bottom' },
        hAxis: { title: 'Data' },
        vAxis: { 
            title: 'Resultado',
            viewWindow: {
                min: escalaMinima, 
                max: escalaMaxima
            }
        },
        width: '100%',
        height: 500,
        series: {
            0: { color: '#1b9e77' }, 
            1: { color: '#ff0000', lineDashStyle: [4, 4] }, 
            2: { color: '#0000ff', lineDashStyle: [4, 4] }  
        }
    };

   
    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
    chart.draw(data, options);
}



</script>


    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/datatables.js"></script>
    <script type="text/javascript" src="assets/js/jquery.mask.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
           
            $('#marcador').change(function() {
                var marcadorSelecionado = $(this).val();

                if (marcadorSelecionado) {
                    var partes = marcadorSelecionado.split('_');
                    var marcador = partes[0];  
                    var medida = partes[1];   

                    window.location.href = "compararExames.php?idCliente=<?= $idCliente ?>&marcador=" + marcador + "&medida=" + medida;
                }
            });
        });
    </script>

</body>

</html>
