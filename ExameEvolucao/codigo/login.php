<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">  <!-- icons -->
</head>
<body>
    <div class="container">
        <div class="content first-content">
            <div class="first-column">
                <h2 class="title title-primary">Bem-Vindo</h2>
                <img src="assets/img//logo.png" alt="">
                <p class="description description-primary"> <i>Inscreva-se</i></p>
                <a href="cadastro.php" id="signin" class="btn btn-primary">Criar conta</a>
            </div>    
            <div class="second-column">
                <h2 class="title title-second">Faça o login</h2>
                <form class="form" id="formulario" action="loginAutenticar.php" method="post" autocomplete="off">

                    <p class="description description-second">Email</p>
                    <label class="label-input" for="email">
                        <i class="far fa-envelope icon-modify"></i>
                        <input class="form-control" id="email" name="email" type="email" required>
                    </label>
                    <label class="error" for="email"></label>  
                    
                    <p class="description description-second">Senha</p>
                    <label class="label-input" for="senha">
                        <i class="fas fa-lock icon-modify"></i>
                        <input class="form-control" id="senha" name="senha" type="password" required>
                    </label>
                    <label class="error" for="senha"></label>  

                    <button class="btn btn-second">ENTRAR</button>        
                </form>
            </div>
        </div>
</div>
            <script type="text/javascript" src="assets/js/jquery.js"></script>
			<script type="text/javascript" src="assets/js/bootstrap.js"></script>
			<script type="text/javascript" src="assets/js/jquery.validate.js"></script>		
			<script type="text/javascript" src="assets/js/jquery.mask.js"></script>			
			<script type="text/javascript" src="assets/js/login.js"></script>			
</body>
</html>