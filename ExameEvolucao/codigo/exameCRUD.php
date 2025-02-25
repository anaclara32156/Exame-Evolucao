<?php

function executarRequisicao($metodo, $url, $dados = null) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    switch ($metodo) {
        case "POST":
            curl_setopt($ch, CURLOPT_POST, true);
            if ($dados) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
            }
            break;
        case "PUT":
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            if ($dados) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados));
            }
            break;
        case "DELETE":
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            break;
    }

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    $resultado = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Erro: ' . curl_error($ch);
    }

    curl_close($ch);

    return json_decode($resultado, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'listarUnidadeDeMedidaPorMarcador') {
    $idMarcador = $_POST['idMarcador'];
    $unidades = listarUnidadeDeMedidaPorMarcador($idMarcador);
    echo json_encode($unidades);
    exit;
}


function listarExame() {
    return executarRequisicao("GET", "http://localhost:8087/api/v1/exame");
}

function listarExamePorCliente($idCliente) {
    return executarRequisicao("GET", "http://localhost:8087/api/v1/exame/cliente/{$idCliente}");
}

function listarExamePorMarcadorEClienteEMedida($marcador, $idCliente, $medida) {
    return executarRequisicao("GET", "http://localhost:8087/api/v1/exame/marcador/{$marcador}/idCliente/{$idCliente}?medida={$medida}");
}

function listarValorPorMarcadorMedidaESexo($idMarcador, $unidadeDeMedida, $sexoBiologico) {
    return executarRequisicao("GET", "http://localhost:8087/api/v1/valor/marcador/{$idMarcador}/sexoBiologico/{$sexoBiologico}?unidadeDeMedida={$unidadeDeMedida}");
}

function listarUnidadeDeMedidaPorMarcador($idMarcador) {
    return executarRequisicao("GET", "http://localhost:8087/api/v1/valor/unidades/{$idMarcador}");
}

function recuperarClientePorId($id) {
    return executarRequisicao("GET", "http://localhost:8087/api/v1/cliente/{$id}");
}

function listarMarcadores() {
    return executarRequisicao("GET", "http://localhost:8087/api/v1/marcador");
}

function listarMarcadorPorGrupoEUsuario($grupo, $idUsuario) {
   return executarRequisicao("GET", "http://localhost:8087/api/v1/marcador/usuario/{$idUsuario}/grupo/{$grupo}");
}

function listarMarcadoresUnicosComUnidade($idCliente) {
    return executarRequisicao("GET", "http://localhost:8087/api/v1/exame/cliente/{$idCliente}/unicos");
}

function recuperarExamePorId($id) {
    return executarRequisicao("GET", "http://localhost:8087/api/v1/exame/{$id}");
}

function salvarExame($id, $marcador, $grupo, $dataColeta, $resultado, $idCliente, $idMarcador, $medida) {
    $dados = array(
        "marcador" => $marcador,
        "grupo" => $grupo,
        "dataColeta" => $dataColeta,
        "resultado" => $resultado,
        "idCliente" => $idCliente,
        "idMarcador" => $idMarcador,
        "medida" => $medida,
    );

    if ($id > 0) {
        $dados["id"] = $id;
        return executarRequisicao("PUT", "http://localhost:8087/api/v1/exame/", $dados);
    } else {
        return executarRequisicao("POST", "http://localhost:8087/api/v1/exame", $dados);
    }
}

function excluirExame($id) {
    return executarRequisicao("DELETE", "http://localhost:8087/api/v1/exame/{$id}");
}
 ?>