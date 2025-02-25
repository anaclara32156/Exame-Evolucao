<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="content first-content">
            <div class="first-column">
                <h2 class="title title-primary">Bem-Vindo</h2>
                <img src="assets/img/logo.png" alt="">
                <p class="description description-primary">Já possui uma conta?</p>
                <a href="login.php" id="signin" class="btn btn-primary">Entrar</a>
            </div>    
            <div class="second-column">
                <h2 class="title title-second">Cadastre-se</h2>
                <form id="formulario" class="form" action="usuarioSalvar.php" method="post" enctype="multipart/form-data">
                    <p class="description description-second">Nome</p>
                    <label class="label-input" for="nome">
                        <i class="far fa-user icon-modify"></i>
                        <input class="form-control" id="nome" name="nome" type="text">
                    </label>
                    <label class="error" for="nome"></label>   

                    <p class="description description-second">CPF</p>
                    <label class="label-input" for="cpf">
                        <i class="far fa-file icon-modify"></i>
                        <input class="form-control" id="cpf" name="cpf" type="text">
                    </label>
                    <label class="error" for="cpf"></label>      


                    <p class="description description-second">Email</p>
                    <label class="label-input" for="email">
                        <i class="far fa-envelope icon-modify"></i>
                        <input class="form-control" id="email" name="email" type="email">
                    </label>
                    <label class="error" for="email"></label>   
                    
                    <p class="description description-second">Senha</p>
                    <label class="label-input" for="senha">
                        <i class="fas fa-lock icon-modify"></i>
                        <input class="form-control" id="senha" name="senha" type="password">
                    </label>
                    <label class="error" for="senha"></label>   
                    
                    <button type="submit" class="btn btn-second">Cadastrar</button>        
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/jquery.validate.js"></script>        
    <script type="text/javascript" src="assets/js/jquery.mask.js"></script>            
    <script type="text/javascript" src="assets/js/usuarioFormulario.js"></script>  
</body>
</html>
