<?php			
	include_once "clienteCRUD.php";
    $dadosUsuario = $_SESSION['dadosUsuario'];
	
    $email = $_POST['email'];
    $id = $_POST['id'];
    $idUsuario = $dadosUsuario['id'];

    $quantidade = verificarClientePorEmail($id, $email, $usuario);
 
    if($quantidade == 0){
        echo "true";
    } else{
        echo "false";
    }
?>	