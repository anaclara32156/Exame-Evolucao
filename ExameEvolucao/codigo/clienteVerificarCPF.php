<?php			
	include_once "clienteCRUD.php";
    $dadosUsuario = $_SESSION['dadosUsuario'];
	
    $cpf = $_POST['cpf'];
    $id = $_POST['id'];
    $idUsuario = $dadosUsuario['id'];

    $quantidade = verificarClientePorCPF($id, $cpf, $idUsuario);

    if($quantidade == 0){
        echo "true";
    } else{
        echo "false";
    }  
?>	