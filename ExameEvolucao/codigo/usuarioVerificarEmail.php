<?php			
	include_once "usuarioCRUD.php";
	
    $email = $_POST['email'];
    $id = $_POST['id'];

    $quantidade = verificarUsuarioPorEmail($id, $email);
 
    if($quantidade == 0){
        echo "true";
    } else{
        echo "false";
    }
?>	