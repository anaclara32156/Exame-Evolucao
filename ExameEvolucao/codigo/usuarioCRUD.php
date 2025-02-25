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
    curl_close($ch);
    
    return json_decode($resultado, true);
}

function listarUsuario() {
    return executarRequisicao("GET", "http://localhost:8087/api/v1/usuario");
}

function buscarUsuarioPorId($id) {
    return executarRequisicao("GET", "http://localhost:8087/api/v1/usuario/{$id}");
}

function salvarUsuario($id, $nome, $cpf, $email, $senha) {
    $dados = array(
        "nome" => $nome,
        "cpf" => $cpf,
        "email" => $email,
        "senha" => $senha
    );

    if ($id > 0) {
        $dados["id"] = $id;
        return executarRequisicao("PUT", "http://localhost:8087/api/v1/usuario/{$id}", $dados);
    } else {
        return executarRequisicao("POST", "http://localhost:8087/api/v1/usuario", $dados);
    }
}

function excluirUsuario($id) {
    return executarRequisicao("DELETE", "http://localhost:8087/api/v1/usuario/{$id}");
}

function verificarUsuario($id, $nome) {
    $usuarios = listarUsuario();
    foreach ($usuarios as $u) {
        if ($u['nome'] == $nome && $u['id'] != $id) {
            return true;
        }
    }
    return false;
}

function autenticarUsuario($email, $senha) {
    // Busca todos os usuários da API
    $usuarios = listarUsuario();

    // Verifica se as credenciais correspondem a algum usuário
    foreach ($usuarios as $u) {
        if ($u['email'] == $email && $u['senha'] == $senha) {
            return $u; // Retorna os dados do usuário autenticado
        }
    }
    
    // Se não encontrar correspondência, retorna null
    return null;
}

function verificarUsuarioPorEmail($id, $email) {
    $usuarios = listarUsuario(); // Obtém todos os clientes
    foreach ($usuarios as $u) {
        if ($u['email'] == $email && $u['id'] != $id) {
            return true;
        }
    }
    return false;
}

function verificarUsuarioPorCPF($id, $cpf) {
    $usuarios = listarUsuario(); // Obtém todos os clientes
    foreach ($usuarios as $u) {
        if ($u['cpf'] == $cpf && $u['id'] != $id) {
            return true;
        }
    }
    return false;
}

?>
