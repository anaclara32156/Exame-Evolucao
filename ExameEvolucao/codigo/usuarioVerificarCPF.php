<?php			
	include_once "usuarioCRUD.php";
	
    $cpf = $_POST['cpf'];
    $id = $_POST['id'];

    $quantidade = verificarUsuarioPorCPF($id, $cpf);
 
    if($quantidade == 0){
        echo "true";
    } else{
        echo "false";
    }  
?>	