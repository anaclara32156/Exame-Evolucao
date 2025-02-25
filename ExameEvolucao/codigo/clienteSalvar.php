<?php
session_start();
include_once "clienteCRUD.php";
$dadosUsuario = $_SESSION['dadosUsuario'];

$id = $_POST['id'];
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$dataNascimento = $_POST['dataNascimento'];
$sexo = $_POST['sexo'];
$tel = $_POST['tel'];
$idUsuario = $dadosUsuario['id'];

$resultado = salvarCliente($id, $nome, $cpf, $email, $dataNascimento, $sexo, $tel, $idUsuario);

if($resultado){
    echo "<script>alert('Registro salvo com sucesso!');</script>";
    echo "<script>window.location.replace('index.php');</script>";
} else {
    echo "<script>alert('Erro ao salvar o registro');</script>";
    echo "<script>window.location.replace('clienteFormulario.php');</script>";
}
?>
