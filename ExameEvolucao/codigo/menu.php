<?php
  if(!isset($_SESSION['dadosUsuario'])){
    echo "<script>alert('Acesso negado!'); location.href='login.php';</script>"; 			
  }

  $dadosUsuario = $_SESSION['dadosUsuario'];
?>

<nav class="navbar navbar-expand-md navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="assets/img/logo.png" alt="Logo da Agência BRN" class="logoCabecalho">
    </a>
    <div class="d-flex align-items-center ms-auto">
      <span class="navbar-text text-white"><?php echo $dadosUsuario['nome']; ?></span>
      <a href="loginEncerrar.php" class="btn-sair"><button>Sair</button></a>
    </div>
  </div>
</nav>

