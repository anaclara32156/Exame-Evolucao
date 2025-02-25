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

function salvarMarcador($id, $nomeMarcador, $sexoBiologico, $grupo, $idTipoDeValor, $unidadeDeMedida, $idadeInferior, $proprioValor, $eMaximo, $idadeSuperior, $idUsuario) {
    $dados = array(
        "nomeMarcador" => $nomeMarcador,
        "sexoBiologico" => $sexoBiologico,
        "grupo" => $grupo,
        "idTipoDeValor" => $idTipoDeValor,
        "unidadeDeMedida" => $unidadeDeMedida,
        "idadeInferior" => $idadeInferior,
        "proprioValor" => $proprioValor,
        "eMaximo" => $eMaximo,
        "idadeSuperior" => $idadeSuperior,
        "idUsuario" => $idUsuario,
    );

    if ($id > 0) {
        $dados["id"] = $id;
        return executarRequisicao("PUT", "http://localhost:8087/api/v1/marcador/", $dados);
    } else {
        return executarRequisicao("POST", "http://localhost:8087/api/v1/marcador", $dados);
    }
}

function validarExistente($id, $nomeMarcador, $sexoBiologico, $grupo, $idTipoDeValor, $unidadeDeMedida, $idadeInferior, $proprioValor, $eMaximo, $idadeSuperior, $idUsuario) {
    $dados = array(
        "nomeMarcador" => $nomeMarcador,
        "sexoBiologico" => $sexoBiologico,
        "grupo" => $grupo,
        "idTipoDeValor" => $idTipoDeValor,
        "unidadeDeMedida" => $unidadeDeMedida,
        "idadeInferior" => $idadeInferior,
        "proprioValor" => $proprioValor,
        "eMaximo" => $eMaximo,
        "idadeSuperior" => $idadeSuperior,
        "idUsuario" => $idUsuario,
    );
    $resposta = executarRequisicao("POST", "http://localhost:8087/api/v1/marcador/existente", $dados);
    
    if (is_array($resposta)) {
        return $resposta['mensagem'] ?? 'Valor já existente.';
    }

    // Se for string, faz o decode
    $respostaDecodificada = json_decode($resposta, true);
    return $respostaDecodificada['mensagem'] ?? 'Valor já existente';
 }

?>