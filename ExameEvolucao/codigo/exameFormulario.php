<?php 
session_start();
include_once "exameCRUD.php";
$dadosUsuario = $_SESSION['dadosUsuario'];
$idUsuario = $dadosUsuario['id'];

$id = 0;
$grupo = "";
$dataColeta = "";
$idCliente = 0;
$resultado = "";
$medida = "";
$marcadoresDisponiveis = [];
$unidadesDisponiveis = [];
$nomeMarcador = ""; 

if (isset($_GET['idCliente'])) {
    $idCliente = $_GET['idCliente'];
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $registro = recuperarExamePorId($id);
    $grupo = $registro['grupo'];
    $dataColeta = $registro['dataColeta'];
    $nomeMarcador = $registro['marcador'];
    $resultado = $registro['resultado'];
    $medida = $registro['medida'];
    $idCliente = $registro['idCliente'];
    $idMarcador = $registro['idMarcador']; 
    $unidadesDisponiveis = listarUnidadeDeMedidaPorMarcador($idMarcador);
}

if (isset($_GET['grupo']) && !empty($_GET['grupo'])) {
    $grupo = urldecode($_GET['grupo']);
    $grupoCodificado = $_GET['grupo'];

    if ($grupo === 'Perfil Metabólico') {
        $grupoCodificado = 'Perfil%20Metabólico'; 
    } 

    $marcadoresDisponiveis = listarMarcadorPorGrupoEUsuario($grupoCodificado, $idUsuario);
}

if (isset($_GET['idMarcador'])) {
    $idMarcadorSelecionado = $_GET['idMarcador'];
    $unidadesDisponiveis = listarUnidadeDeMedidaPorMarcador($idMarcadorSelecionado);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <title>Adicionar Exame</title>
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/estilo.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<?php include_once "menu.php"; ?>

<h1 class="d-flex justify-content-center align-items-center">
    <a id="btn-left" class="btn btn-left" href="exame.php?idCliente=<?= $idCliente ?>">
        <i class="fa fa-arrow-left"></i> Voltar
    </a>
    <span>Adicionar Exame</span>
    <p>Não encontrou algum marcador?</p>
    <a id="btn-right" class="btn btn-right" href="marcadorFormulario.php?idCliente=<?= $idCliente; ?>"> 
    Adicionar Novo Marcador
</a>
</h1>

<div class="container">
    <hr/>
    <div class="formulario">
        <form id="formulario" action="exameSalvar.php" method="post">
            <input type="hidden" id="id" name="id" value="<?= $id; ?>">
            <input type="hidden" id="idCliente" name="idCliente" value="<?= htmlspecialchars($idCliente); ?>">

            <div class="row form-group align-items-center">
                <div class="col-md-8">
                    <label for="grupo">Qual o grupo de exames?*</label>
                    <div class="form-check form-check-inline-block">
                        <input class="form-check-input grupo-radio" type="radio" name="grupo" value="Perfil Metabólico" 
                            <?= $grupo === "Perfil Metabólico" ? "checked" : ""; ?> id="perfilMetabolico">
                        <label class="form-check-label" for="perfilMetabolico">Perfil Metabólico Cardiovascular</label>
                    </div>
                    <div class="form-check form-check-inline-block">
                        <input class="form-check-input grupo-radio" type="radio" name="grupo" value="Leucograma" 
                            <?= $grupo === "Leucograma" ? "checked" : ""; ?> id="leucograma">
                        <label class="form-check-label" for="leucograma">Hemograma Leucograma</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="dataColeta">Data da coleta*</label>
                    <input class="form-control" id="dataColeta" name="dataColeta" value="<?= htmlspecialchars($dataColeta); ?>" type="date">
                </div>
            </div>

            <div class="content-formulario">
                <div id="marcadores-dinamicos">
                    <div class="row form-group marcador-linha" data-index="1">
                        <div class="col-md-4">
                            <label for="nomeMarcador1">Nome do marcador*</label>
                            <select class="form-control" id="nomeMarcador1" name="nomeMarcador[]" data-index="1">
                                <option value="">Selecione</option>
                                <?php foreach ($marcadoresDisponiveis as $marcadorDisponivel): ?>
                                    <?php $selected = ($marcadorDisponivel['nomeMarcador'] === $nomeMarcador) ? 'selected' : ''; ?>
                                    <option value="<?= htmlspecialchars($marcadorDisponivel['nomeMarcador']); ?>" 
                                        data-id="<?= htmlspecialchars($marcadorDisponivel['id']); ?>" <?= $selected; ?>>
                                        <?= htmlspecialchars($marcadorDisponivel['nomeMarcador']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="resultado1">Resultado*</label>
                            <input class="form-control" id="resultado1" name="resultado[]" type="text" value="<?= htmlspecialchars($resultado); ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="medida1">Unidade de medida*</label>
                            <select class="form-control" id="medida1" name="medida[]">
                                <option value="">Selecione</option>
                                <?php foreach ($unidadesDisponiveis as $unidade): ?>
                                    <option value="<?= htmlspecialchars($unidade); ?>" 
                                        <?= ($unidade === $medida) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($unidade); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="hidden" id="idMarcador1" name="idMarcador[]" value="<?= isset($idMarcador) ? htmlspecialchars($idMarcador) : ''; ?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12 text-center">
                        <button type="button" class="btn btn-outline-primary" id="addMarcador">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
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
<script type="text/javascript" src="assets/js/exameFormulario.js"></script>	
<script>
    $(document).ready(function() {
        // Função para atualizar a URL quando o grupo for alterado
        $(document).on('change', '[name="grupo"]', function() {
            var grupoSelecionado = $(this).val();

            if (grupoSelecionado) {
                var grupoCodificado = encodeURIComponent(grupoSelecionado);
                var url = new URL(window.location.href);
                url.searchParams.set('grupo', grupoCodificado);
                window.location.href = url.toString();
            }
        });

        $(document).on('change', '[name="nomeMarcador[]"]', function () {
            const index = $(this).data('index');
            const idMarcador = $(this).find('option:selected').data('id');
            if (idMarcador) {
                // Chama a função AJAX para buscar as unidades de medida para o marcador selecionado
                atualizarUnidadesDeMedida(idMarcador, index);
            }
        });

        function atualizarIdMarcador(selectElement) {
    const index = $(selectElement).data('index');
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const idMarcador = selectedOption.getAttribute('data-id');

    // Atualiza o campo oculto com o ID do marcador para o elemento específico
    $(`#idMarcador${index}`).val(idMarcador);

}

// Delegação de eventos para os selects de marcadores
$(document).on('change', '[name="nomeMarcador[]"]', function() {
    atualizarIdMarcador(this); // Atualiza o ID ao mudar o select
});

        function atualizarUnidadesDeMedida(idMarcador, index) {
            $.ajax({
                url: 'exameCRUD.php',
                type: 'POST',
                data: { 
                    action: 'listarUnidadeDeMedidaPorMarcador',
                    idMarcador: idMarcador
                },
                success: function(response) {
                    const unidadeSelect = $(`#medida${index}`);
                    unidadeSelect.empty(); 
                    
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        console.error('Erro ao tentar parsear a resposta como JSON', e);
                    }

                    if (Array.isArray(response) && response.length > 0) {
                        unidadeSelect.append('<option value="">Selecione</option>');
                        response.forEach(function(unidade) {
                            unidadeSelect.append(`<option value="${unidade}">${unidade}</option>`);
                        });
                    } else {
                        unidadeSelect.append('<option value="">Nenhuma unidade disponível</option>');
                    }
                },
                error: function() {
                    alert('Erro ao buscar unidades de medida.');
                }
            });
        }

        
    $('#addMarcador').click(function() {
    const index = $('#marcadores-dinamicos .marcador-linha').length + 1;
    const novoMarcador = `
    <div class="row form-group marcador-linha" data-index="${index}">
        <div class="col-md-4">
            <label for="nomeMarcador${index}">Nome do marcador*</label>
            <select class="form-control" id="nomeMarcador${index}" name="nomeMarcador[]" data-index="${index}">
                <option value="">Selecione</option>
                <?php foreach ($marcadoresDisponiveis as $marcadorDisponivel): ?>
                    <option value="<?= htmlspecialchars($marcadorDisponivel['nomeMarcador']); ?>" 
                            data-id="<?= htmlspecialchars($marcadorDisponivel['id']); ?>">
                        <?= htmlspecialchars($marcadorDisponivel['nomeMarcador']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="resultado${index}">Resultado*</label>
            <input class="form-control" id="resultado${index}" name="resultado[]" type="text">
        </div>
        <div class="col-md-4">
            <label for="medida${index}">Unidade de medida*</label>
            <select class="form-control" id="medida${index}" name="medida[]">
                <option value="">Selecione</option>
                <?php foreach ($unidadesDisponiveis as $unidade): ?>
                    <option value="<?= htmlspecialchars($unidade); ?>">
                        <?= htmlspecialchars($unidade); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <input type="hidden" id="idMarcador${index}" name="idMarcador[]" value="">
    </div>`;
    $('#marcadores-dinamicos').append(novoMarcador);

    $("#formulario").validate().element(`#nomeMarcador${index}`);
    $("#formulario").validate().element(`#resultado${index}`);
    $("#formulario").validate().element(`#medida${index}`);
});


    // Sincroniza IDs antes de enviar
    $('#formulario').submit(function() {
        $('[name="nomeMarcador[]"]').each(function() {
            const index = $(this).data('index');
            const idMarcador = $(this).find('option:selected').data('id');
            $(`#idMarcador${index}`).val(idMarcador);
        });
    });
    });
</script>
</body>
</html>
