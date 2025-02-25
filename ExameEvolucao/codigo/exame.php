<?php
session_start();
include_once "exameCRUD.php";
$dadosUsuario = $_SESSION['dadosUsuario'];
$idUsuario = $dadosUsuario['id'];

if (isset($_GET['idCliente'])) {
    $idCliente = $_GET['idCliente'];
}

$cliente = recuperarClientePorId($idCliente);

$registros = listarExamePorCliente($idCliente);
if (!is_array($registros)) {
    $registros = [];
}

$dadosAgrupados = [];
foreach ($registros as $registro) {
    $marcador = $registro['marcador']; 
    $dadosAgrupados[$marcador][] = $registro;  
}

$dadosAgrupadosPorGrupo = [];
foreach ($registros as $registro) {
    $grupo = $registro['grupo']; 
    $marcador = $registro['marcador']; 
    $dadosAgrupadosPorGrupo[$grupo][$marcador][] = $registro;
}

$coresGrupos = [
    'Leucograma' => '#E6E6FA',
    'Perfil Metabólico' => '#F0FFF0'
];

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <title>Exames do Cliente</title>
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/estilo.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/datatables.css" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body>
    <?php include_once "menu.php"; ?>
    <h1 class="d-flex justify-content-center align-items-center">
    <a id="btn-left" class="btn btn-left" href="index.php">
        <i class="fa fa-arrow-left"></i> Voltar
    </a>
    <span> Exames do Cliente</span> </h1>
    <span class="nome" ><?php echo $cliente['nome']; ?></span>
    <div class="container">
    <hr />
    <div class="content">
        <div class="row form-group">
            <div class="col-md-6 text-left">
                <a href="relatorioExame.php?idCliente=<?= $idCliente ?>" class="btn btn-second">Imprimir</a>

                <div class="legenda-cores mt-3">
                    <p1><strong>Legenda de Cores:</strong></p1>
                    <div>
                        <span class="cor-legenda" style="background-color: <?= $coresGrupos['Perfil Metabólico']; ?>;"></span> Perfil Metabólico
                    </div>
                    <div>
                        <span class="cor-legenda" style="background-color: <?= $coresGrupos['Leucograma']; ?>;"></span> Leucograma
                    </div>
                </div>
            </div>

            <div class="col-md-6 text-right d-flex flex-column align-items-end">
                <a href="exameFormulario.php?idCliente=<?= $idCliente ?>" class="btn btn-second mb-2">Novo Exame</a>
                <a href="compararExames.php?idCliente=<?= $idCliente ?>" class="btn btn-second mb-2">Comparar Exames</a>
            </div>
        </div>

        <table id="tabela" class="table">
            <thead class="thead">
                <tr>
                    <th style="display: none;">Grupo</th>
                    <th>Marcador</th>
                    <th>Data de Coleta</th>
                    <th>Resultado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dadosAgrupadosPorGrupo as $grupo => $marcadores): ?>
                    <?php foreach ($marcadores as $marcador => $exames): ?>
                        <?php foreach ($exames as $exame): 
                            $dataColeta = new DateTime($exame['dataColeta']);
                            $dataFormatada = $dataColeta->format('d/m/Y');
                            $corGrupo = $coresGrupos[$grupo] ?? '#f0f0f0'; 
                        ?>
                            <tr class="grupo-<?= $grupo ?>" data-grupo="<?= $grupo ?>" style="background-color: <?= $corGrupo ?>;">
                                <td style="display: none;"><?= $grupo ?></td>
                                <td><?= $marcador ?></td>
                                <td><?= $dataFormatada ?></td>
                                <td><?= $exame['resultado'] ?> <?= $exame['medida'] ?></td>
                                <td class="text-right">
                                    <a href="exameFormulario.php?id=<?= $exame['id'] ?>&grupo=<?= $exame['grupo'] ?>" 
                                       id="btn-acoes-editar" 
                                       class="btn float-right mr-1" 
                                       style="background-color: <?= $corGrupo ?>;">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            id="btn-acoes-excluir" 
                                            onclick="confirmarExclusao(<?= $exame['id'] ?>, <?= $idCliente ?>)" 
                                            class="btn float-right" 
                                            style="background-color: <?= $corGrupo ?>;">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/datatables.js"></script>
    <script type="text/javascript" src="assets/js/jquery.mask.js"></script>
    <script type="text/javascript" src="assets/js/exameTabela.js"></script>
    <script>
     $.fn.dataTable.ext.errMode = 'none';

$(document).ready(function () {
    inicializarTabela();
});

function inicializarTabela() {
    $('#tabela').DataTable({
        order: [[0, 'asc']],
        columnDefs: [
            { targets: [0], visible: false },
        ],
        drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var last = null;

            api.column(0, { page: 'current' })
                .data()
                .each(function (grupo, i) {
                    if (last !== grupo) {
                        $(rows)
                            .eq(i)
                            .before(
                                `<tr class="group" style="background-color: #d9edf7;"><td colspan="4"><strong>Grupo: ${grupo}</strong></td></tr>`
                            );
                        last = grupo;
                    }
                });
        },
    });
}
</script>
</body>

</html>
