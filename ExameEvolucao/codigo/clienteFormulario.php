<?php
session_start();
include_once "clienteCRUD.php";

$id = 0;
$nome = "";
$cpf = "";
$email = "";
$dataNascimento = "";
$sexo = "";
$tel = "";
$idUsuario = "";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $registro = recuperarClientePorId($id);
    $nome = $registro['nome'];
    $cpf = $registro['cpf'];
    $email = $registro['email'];
    $dataNascimento = $registro['dataNascimento'];
    $sexo = $registro['sexo'];
    $tel = $registro['tel'];
    $idUsuario = $registro['idUsuario'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <title>Cliente</title>
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/estilo.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body> 

    <?php include_once "menu.php"; ?>

   <h1 class="d-flex justify-content-center align-items-center">
    <a id="btn-left" class="btn btn-left" href="index.php">
        <i class="fa fa-arrow-left"></i> Voltar
</a>
    <span>Cadastrar Cliente</span>
</h1>


    <div class="container">
        <hr/>    
            <div class="formulario">            
                <form id="formulario" action="clienteSalvar.php" method="post">
                <div class="content-formulario">
                    <!-- Campo oculto (invisível) -->
					<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                    
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label for="nome">Nome completo*</label>
                            <input class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" type="text">
                            <label class="error" for="nome"></label>
                        </div>    
                    </div>    
                    
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="dataNascimento">Data de nascimento*</label>  
                            <input class="form-control" id="dataNascimento" name="dataNascimento" value="<?php echo htmlspecialchars($dataNascimento);?>" type="date">
                            <label class="error" for="dataNascimento"></label>                  
                        </div>    
                        <div class="col-md-4">
                            <label for="cpf">CPF*</label>  
                            <input class="form-control" id="cpf" name="cpf" value="<?php echo htmlspecialchars($cpf); ?>" type="text">
                            <label class="error" for="cpf"></label>                    
                        </div>
                        <div class="col-md-4">
                            <label for="sexo">Sexo biológico*</label>  
                            <select class="form-control" id="sexo" name="sexo">
                                <option value="">Selecione</option>
                                <option value="M" <?php if ($sexo == 'M') echo 'selected'; ?>>Masculino</option>
                                <option value="F" <?php if ($sexo == 'F') echo 'selected'; ?>>Feminino</option>
                            </select>
                            <label class="error" for="sexo"></label>                    
                        </div>    
                    </div>           
                    
                    <div class="row form-group">
                        <div class="col-md-8">
                            <label for="email">Email*</label>  
                            <input class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" type="text">
                            <label class="error" for="email"></label>                    
                        </div>    
                        <div class="col-md-4">
                            <label for="tel">Telefone</label>  
                            <input class="form-control" id="tel" name="tel" value="<?php echo htmlspecialchars($tel); ?>" type="text">
                            <label class="error" for="tel"></label>                    
                        </div>
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
    <script type="text/javascript" src="assets/js/clienteFormulario.js"></script>                 
</body>
</html>
