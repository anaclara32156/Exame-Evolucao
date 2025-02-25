<?php		
	include_once "usuarioCRUD.php";
	include_once "util.php";

	$id = $_POST['id'];
	$nome = $_POST['nome'];
	$cpf = $_POST['cpf'];
	$email = $_POST['email'];
	$senha = $_POST['senha'];

	$quantidade = salvarUsuario($id, $nome, $cpf, $email, $senha);

	if($quantidade){
		echo  "<script>alert('Cadastro realizado com sucesso!');</script>";
		echo  "<script>window.location.replace('login.php');</script>";
	}else{
		echo  "<script>alert('Erro ao cadastro e registro');</script>";
		echo  "<script>window.location.replace('cadastro.php');</script>";		
	}
?>	


	