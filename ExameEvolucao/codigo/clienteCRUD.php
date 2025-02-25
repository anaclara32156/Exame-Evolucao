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

function listarCliente() {
    return executarRequisicao("GET", "http://localhost:8087/api/v1/cliente");
}

function listarClientePorUsuario($idUsuario) {
    return executarRequisicao("GET", "http://localhost:8087/api/v1/cliente/usuario/{$idUsuario}");
}

function recuperarClientePorId($id) {
    return executarRequisicao("GET", "http://localhost:8087/api/v1/cliente/{$id}");
}

function salvarCliente($id, $nome, $cpf, $email, $dataNascimento, $sexo, $tel, $idUsuario) {
    $dados = array(
        "nome" => $nome,
        "cpf" => $cpf,
        "email" => $email,
        "dataNascimento" => $dataNascimento,
        "sexo" => $sexo,
        "tel" => $tel,
        "idUsuario" => $idUsuario,
    );

    if ($id > 0) {
        $dados["id"] = $id;
        return executarRequisicao("PUT", "http://localhost:8087/api/v1/cliente/", $dados);
    } else {
        return executarRequisicao("POST", "http://localhost:8087/api/v1/cliente", $dados);
    }
}

function excluirCliente($id) {
    return executarRequisicao("DELETE", "http://localhost:8087/api/v1/cliente/{$id}");
}

function verificarClientePorEmail($id, $email, $idUsuario) {
    $clientes = listarClientePorUsuario($idUsuario);
    foreach ($clientes as $cliente) {
        if ($cliente['email'] == $email && $cliente['id'] != $id) {
            return true;
        }
    }
    return false;
}

function verificarClientePorCPF($id, $cpf, $idUsuario) {
    $clientes = listarClientePorUsuario($idUsuario);
    foreach ($clientes as $cliente) {
        if ($cliente['cpf'] == $cpf && $cliente['id'] != $id) {
            return true;
        }
    }
    return false;
}?>