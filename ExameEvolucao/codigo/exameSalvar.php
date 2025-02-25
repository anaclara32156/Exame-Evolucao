<?php
session_start();
include_once "exameCRUD.php";

$id = $_POST['id'];
$dataColeta = $_POST['dataColeta'];
$idCliente = $_POST['idCliente'];
$grupo = $_POST['grupo'];
$marcadores = $_POST['nomeMarcador'] ?? [];
$idMarcadores = $_POST['idMarcador'] ?? [];
$resultados = $_POST['resultado'] ?? [];
$medidas = $_POST['medida'] ?? [];

foreach ($marcadores as $index => $marcador) {
    $idMarcador = $idMarcadores[$index] ?? '';
    $resultado = $resultados[$index] ?? '';
    $medida = $medidas[$index] ?? '';

    $success = salvarExame($id, $marcador, $grupo, $dataColeta, $resultado, $idCliente, $idMarcador, $medida);

    if (!$success) {
        echo "<script>alert('Erro ao salvar o marcador: {$marcador}');</script>";
        exit;
    }
}

echo "<script>
    alert('Registro salvo com sucesso!'); 
    window.location.href = 'exame.php?idCliente={$idCliente}';
    </script>";
exit;
