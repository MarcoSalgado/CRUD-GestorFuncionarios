<?php
  include("../database/database.php"); //incluir a base de dados!
  session_start(); // Iniciar a sessão


  if ($_SESSION["perms"] != "full"){          //Manda para a pagina de login quem tentar entrar nesta pagina sem perms de admin
    header("Location: ../login.php");
    exit;
  }

  if(isset($_POST['departamentos'])){
    header("Location: departamentos/departamentos.php");
    exit();
}

if(isset($_POST['processamentos'])){
    header("Location: processamentos/processar_salario.php");
    exit();
}

if(isset($_POST['gestorusers'])){
    header("Location: gestorusers/gestorusers.php");
    exit();
}
if(isset($_POST['sair'])){
    header("Location: ../login.php");
    exit();
  }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Button Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .button {
            font-size: 20px;
            padding: 20px 40px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <form action="" method="post">
        <div class="row">
            <div class="col-md-4">
                <button class="btn btn-primary btn-lg btn-block button" name="departamentos">Departamentos</button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-success btn-lg btn-block button" name="processamentos">Processamentos</button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-info btn-lg btn-block button" name="gestorusers">Gerir Utilizadores</button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <button class="btn btn-danger btn-lg btn-block button" name="sair">Sair</button>
            </div>
        </div>
        </form>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>