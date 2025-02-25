<?php
include_once "exameCRUD.php";

$marcadores = listarMarcadores();
echo json_encode($marcadores);
?>
