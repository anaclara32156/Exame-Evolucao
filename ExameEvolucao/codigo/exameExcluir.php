<?php
    include_once "exameCRUD.php";

    $id= $_POST['id'];
    $idCliente= $_POST['idCliente'];
    $resultado = excluirExame($id); 
    
    if($resultado){
        echo "<script>alert('Registro excluído com sucesso!');</script>";
        header('Location: exame.php?idCliente=' . $idCliente); 
    }else{
        echo "<script>alert('Erro ao excluir o registro');</script>";
    }
?>
