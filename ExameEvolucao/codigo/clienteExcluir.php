<?php
    include_once "clienteCRUD.php";

    $id = $_POST['id'];
    $resultado = excluirCliente($id); 
    
    if($resultado){
        echo "<script>alert('Registro excluído com sucesso!');</script>";
    }else{
        echo "<script>alert('Erro ao excluir o registro');</script>";
    }

    echo "<script>window.location.replace('index.php');</script>";
?>
