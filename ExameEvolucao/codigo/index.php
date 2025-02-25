<?php
    session_start();
    include_once "clienteCRUD.php";
    $dadosUsuario = $_SESSION['dadosUsuario'];
    $idUsuario = $dadosUsuario['id'];
    $registros = listarClientePorUsuario($idUsuario);
    
    if (!is_array($registros)) {
        $registros = [];
    }
?>

<html>

<head>
    <meta charset="utf-8" />
    <title>Cliente</title>
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/estilo.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/datatables.css" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body>
    <?php
        include_once "menu.php";
    ?>
    <h1>Meus Clientes</h1>
    <div class="container">
        <hr />
        <div class="content">
            <a href="clienteFormulario.php" class="btn btn-second float-right mb-2">Novo Cliente</a>
            <table id="tabela" class="table">
                <thead class="thead">
                    <tr>
                        <th>Nome do Cliente</th>
                        <th>Acessar Exames</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
    <?php
        foreach($registros as $registro) {
            echo "<tr>";
            echo "<td>{$registro['nome']}</td>";
            echo "<td><a href='exame.php?idCliente={$registro['id']}' class='btn float-left'><i>Exames</i></a></td>";
            echo "<td class='text-right'>";
            echo "<a href='clienteFormulario.php?id={$registro['id']}' id='btn-acoes-editar' class='btn float-right mr-1'><i class='fa fa-edit'></i></a>";
            echo "<button type='button' id='btn-acoes-excluir' onclick='confirmarExclusao({$registro['id']})' class='btn float-right'><i class='fa fa-trash'></i></button>";
            echo "</td>";
            echo "</tr>";
        }
    ?>
</tbody>

            </table>
    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/datatables.js"></script>
    <script type="text/javascript" src="assets/js/jquery.mask.js"></script>
    <script type="text/javascript" src="assets/js/clienteTabela.js"></script>
        </div>
    </div>

</body>

</html>
