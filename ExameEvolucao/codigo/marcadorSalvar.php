<?php
session_start();
include_once "marcadorCRUD.php";

    $id = $_POST['id'] ?? '';
    $idCliente = $_POST['idCliente'] ?? null;
    $idUsuario = $_POST['idUsuario'] ?? null;
    $marcador = $_POST['marcador'] ?? '';
    $sexo = $_POST['sexo'] ?? '';
    $grupo = $_POST['grupo'] ?? '';
    $idTiposDeValor = $_POST['idTipoDeValor'] ?? [];
    $unidadesMedida = $_POST['medida'] ?? [];
    $idadesMinima = $_POST['idadeMinima'] ?? [];
    $valores = $_POST['valor'] ?? [];
    $confirmacoes = $_POST['confirmacaoValorMaximo'] ?? [];
    $idadesMaxima = $_POST['idadeMaxima'] ?? [];


    foreach ($idTiposDeValor as $index => $idTipoDeValor) {
        $unidadeMedida = $unidadesMedida[$index] ?? '';
        $idadeMinima = $idadesMinima[$index] ?? '';
        $valor = $valores[$index] ?? '';
        $confirmacao = $confirmacoes[$index] ?? '';
        $idadeMaxima = $idadesMaxima[$index] ?? '';

        print($idTipoDeValor);

        $validacao = validarExistente(
            $id, 
            $marcador, 
            $sexo, 
            $grupo, 
            $idTipoDeValor, 
            $unidadeMedida, 
            $idadeMinima, 
            $valor, 
            $confirmacao, 
           $idadeMaxima,
           $idUsuario
        );

        if ($validacao === "Valor já existente.") {
            echo "<script>
            alert('Erro: Já existe um marcador salvo com esses dados.');
            window.location.href = 'marcadorFormulario.php?idCliente={$idCliente}';
            </script>";
            exit;
        }
    
        $success = salvarMarcador(
            $id, 
            $marcador, 
            $sexo, 
            $grupo, 
            $idTipoDeValor, 
            $unidadeMedida, 
            $idadeMinima, 
            $valor, 
            $confirmacao, 
           $idadeMaxima,
           $idUsuario
        );

        if (!$success) {
            echo "<script>alert('Erro ao salvar o marcador: {$marcador}');</script>";
            exit;
        }
    }

    echo "<script>
    alert('Registro salvo com sucesso!'); 
    window.location.href = 'exameFormulario.php?idCliente={$idCliente}';
    </script>";
exit;

