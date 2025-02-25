<?php	
	session_start();		
	include_once "usuarioCRUD.php";
	
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $registro = autenticarUsuario($email, $senha);
 
    if($registro != null){	
		$_SESSION['dadosUsuario'] = $registro;
		echo "<script>location.href='index.php';</script>"; 
	}else{
		echo "<script>alert('Login ou senha inválido!'); location.href='login.php';</script>"; 			
	}
?>	