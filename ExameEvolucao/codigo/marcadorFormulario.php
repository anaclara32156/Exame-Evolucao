<?php 
session_start();
include_once "clienteCRUD.php";
$dadosUsuario = $_SESSION['dadosUsuario'];
$idUsuario = $dadosUsuario['id'];

$id = 0;
$nomeMarcador = "";
$grupo = "";
$eMaximo = "";
$propioValor = "";
$idadeInferior = "";
$idadeSuperior = "";
$sexo = "";
$idMarcador = "";
$idTipoDeValor = "";

if (isset($_GET['idCliente'])) {
    $idCliente = $_GET['idCliente'];
    $registro = recuperarClientePorId($idCliente);
    $idUsuario = $registro['idUsuario'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <title>Marcador</title>
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/estilo.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body> 

    <?php include_once "menu.php"; ?>

    <h1 class="d-flex justify-content-center align-items-center">
        <a id="btn-left" class="btn btn-left" href="exameFormulario.php?idCliente=<?= $idCliente ?>">
            <i class="fa fa-arrow-left"></i> Voltar
        </a>
        <span>Cadastrar Marcador</span>
    </h1>

    <div class="container">
        <div class="formulario">            
            <form id="formulario" action="marcadorSalvar.php" method="post">
                <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                <input type="hidden" id="idCliente" name="idCliente" value="<?= htmlspecialchars($idCliente); ?>">
                <input type="hidden" id="idUsuario" name="idUsuario" value="<?= htmlspecialchars($idUsuario); ?>">

                <!-- Inputs fora do formulário -->
                <div class="row form-group">
                    <div class="col-md-4">
                        <label for="marcador">Nome do marcador*</label>
                        <input class="form-control" id="marcador" name="marcador" type="text">
                    </div>    
                    <div class="col-md-4">
                        <label for="sexo">Sexo Biológico*</label>
                        <select class="form-control" id="sexo" name="sexo">
                            <option value="">Selecione</option>
                            <option value="M" <?php if ($sexo == 'M') echo 'selected'; ?>>Masculino</option>
                            <option value="F" <?php if ($sexo == 'F') echo 'selected'; ?>>Feminino</option>
                            <option value="U" <?php if ($sexo == 'U') echo 'selected'; ?>>Unissex</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="grupo">Grupo*</label>
                        <select class="form-control" id="grupo" name="grupo">
                            <option value="">Selecione</option>
                            <option value="Leucograma" <?php if ($grupo == 'Leucograma') echo 'selected'; ?>>Leucograma</option>
                            <option value="Perfil Metabólico" <?php if ($grupo == 'Perfil Metabólico') echo 'selected'; ?>>Perfil Metabólico</option>
                        </select>
                    </div>
                </div>

                <div class="content-formulario">
                <div id="marcadores-dinamicos">
                <div class="row form-group marcador-linha" data-index="1">
                <div class="col-md-4">
                  <label for="idTipoDeValor">Tipo de valor*</label>
                    <select class="form-control" id="idTipoDeValor" name="idTipoDeValor[]" data-index="1">
                    <option value="">Selecione</option>
                    <option value="1" <?php if ($idTipoDeValor == '1') echo 'selected'; ?>>Referencial</option>
                    <option value="2" <?php if ($idTipoDeValor == '2') echo 'selected'; ?>>Ideal</option>
                  </select>
                </div>

                    <div class="col-md-4">
                        <label for="medida">Unidade de medida*</label>
                        <input class="form-control" id="medida" name="medida[]" value="" type="text">
                    </div>
                    <div class="col-md-4">
                        <label for="idadeMinima">Idade mínima(em meses)*</label>
                        <input class="form-control" id="idadeMinima" name="idadeMinima[]" value="" type="number">
                    </div>
                </div>

                <div class="row form-group marcador-linha2">
                    <div class="col-md-4">
                        <label for="valor">Valor*</label>
                        <input class="form-control" id="valor" name="valor[]" value="" type="text">
                    </div>
                    <div class="col-md-4">
                        <label for="confirmacaoValorMaximo">O valor é máximo?*</label>
                        <select class="form-control" id="confirmacaoValorMaximo" name="confirmacaoValorMaximo[]">
                             <option value="">Selecione</option> 
                             <option value="Sim">Sim</option>
                             <option value="Nao">Não</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="idadeMaxima">Idade máxima(em meses)*</label>
                        <input class="form-control" id="idadeMaxima" name="idadeMaxima[]" value="" type="number">
                    </div>
                </div>

                <div id="marcadores-dinamicos">
                </div>

                </div>
                <div class="text-center">
                    <button type="button" class="btn-mais" id="addMarcador"><i class="fa fa-plus"></i></button>
                </div>
                
                </div>

                <div class="row form-group">
                <div class="col-md-12 text-center">
                    <button type="submit" id="btn-second-salvar" class="btn btn-second">Salvar</button>
                </div>
            </div>
            </form>        
        </div>
    </div>

    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/jquery.validate.js"></script>        
    <script type="text/javascript" src="assets/js/jquery.mask.js"></script>            
    <script type="text/javascript" src="assets/js/marcadorFormulario.js"></script>
    <script>
$(document).ready(function() {
    $('#addMarcador').click(function() {

        const index = $('#marcadores-dinamicos .marcador-linha').length + 1;
        const novoMarcador = `
            <div class="row form-group marcador-linha" data-index="${index}">
                <div class="col-md-4">
                    <label for="idTipoDeValor${index}">Tipo de valor*</label>
                    <select class="form-control" id="idTipoDeValor${index}" name="idTipoDeValor[]">
                        <option value="">Selecione</option>
                        <option value="1">Referencial</option>
                        <option value="2">Ideal</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="medida${index}">Unidade de medida*</label>
                    <input class="form-control" id="medida${index}" name="medida[]" type="text">
                </div>
                <div class="col-md-4">
                    <label for="idadeMinima${index}">Idade mínima(em meses)*</label>
                    <input class="form-control" id="idadeMinima${index}" name="idadeMinima[]" type="number">
                </div>
                <div class="col-md-4">
                    <label for="valor${index}">Valor*</label>
                    <input class="form-control" id="valor${index}" name="valor[]" type="text">
                </div>
                <div class="col-md-4">
                    <label for="confirmacaoValorMaximo${index}">O valor é máximo?*</label>
                    <select class="form-control" id="confirmacaoValorMaximo${index}" name="confirmacaoValorMaximo[]">
                        <option value="">Selecione</option>
                        <option value="Sim">Sim</option>
                        <option value="Nao">Não</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="idadeMaxima${index}">Idade máxima(em meses)*</label>
                    <input class="form-control" id="idadeMaxima${index}" name="idadeMaxima[]" type="number">
                </div>
            </div>`;

        $('#marcadores-dinamicos').append(novoMarcador);

    $("#formulario").validate().element(`#idTipoDeValor${index}`);
    $("#formulario").validate().element(`#medida${index}`);
    $("#formulario").validate().element(`#idadeMinima${index}`);
    $("#formulario").validate().element(`#valor${index}`);
    $("#formulario").validate().element(`#confirmacaoValorMaximo${index}`);
    $("#formulario").validate().element(`#idadeMaxima${index}`);

    });

    $('#formulario').submit(function() {
       
    });
});
</script>
</body>
</html>
