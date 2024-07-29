<?php
include("../../database/database.php"); // incluir a base de dados!
session_start(); // Iniciar a sessão

if ($_SESSION["perms"] != "full") {
  // Manda para a página de login quem tentar entrar nesta página sem perms de admin
  header("Location: ../../login.php");
  exit;
}

// Verificar se o formulário de criação de departamento foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['departamento'])) {
  $departamento = $_POST['departamento'];

  // Executar a consulta de inserção na tabela de departamentos
  $sqlInsert = "INSERT INTO departamentos (IDdepartamento, Nomedepartamento) VALUES (NULL, ?)";
  $stmt = mysqli_prepare($conn, $sqlInsert);
  mysqli_stmt_bind_param($stmt, 's', $departamento);
  $resultado = mysqli_stmt_execute($stmt);

  // Verificar se a inserção foi bem-sucedida
  if ($resultado) {
    // Redirecionar para departamentos.php com a mensagem de sucesso
    header("Location: departamentos.php?mensagem=Departamento criado com sucesso!");
    exit;
  } else {
    // Redirecionar para departamentos.php com a mensagem de erro
    header("Location: departamentos.php?mensagem=Erro ao criar departamento");
    exit;
  }

  // Fechar a declaração preparada e a conexão com o banco de dados
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}

// Verificar se o formulário de eliminação de departamento foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['departamento-eliminar'])) {
  $departamentoEliminar = $_POST['departamento-eliminar'];

  // Executar a consulta para excluir o departamento correspondente
  $sqlDelete = "DELETE FROM departamentos WHERE IDdepartamento = ?";
  $stmt = mysqli_prepare($conn, $sqlDelete);
  mysqli_stmt_bind_param($stmt, 'i', $departamentoEliminar);
  $resultado = mysqli_stmt_execute($stmt);

  // Verificar se a exclusão foi bem-sucedida
  if ($resultado) {
    // Redirecionar para departamentos.php com a mensagem de sucesso
    header("Location: departamentos.php?mensagem=Departamento eliminado com sucesso!");
    exit;
  } else {
    // Redirecionar para departamentos.php com a mensagem de erro
    header("Location: departamentos.php?mensagem=Erro ao eliminar departamento");
    exit;
  }
}

// Verificar se o formulário de alterar departamento foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['departamento-alterar'])) {
  $departamentoID = $_POST['departamento-alterar'];

  // Armazenar o ID do departamento em uma variável de sessão
  $_SESSION['departamento-id'] = $departamentoID;

  // Redirecionar para departamentos.php com o ID do departamento
  header("Location: departamentos.php?departamento-id=" . $departamentoID);
  exit;
}

// Verificar se o botão "Remover" foi clicado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remover'])) {
    $userID = $_POST['remover'];
  
    // Atualizar a coluna IDdepartamento para 0 no banco de dados para o usuário com o ID especificado ($userID)
    $sqlUpdate = "UPDATE users SET IDdepartamento = 0 WHERE ID = $userID";
    $resultado = mysqli_query($conn, $sqlUpdate);
  
    // Verificar se a atualização foi bem-sucedida
    if ($resultado) {
      // Redirecionar para departamentos.php com a mensagem de sucesso
      header("Location: departamentos.php?mensagem=Usuário removido do departamento com sucesso!");
      exit; // Adicionar o exit para interromper o processamento da página
    } else {
      // Redirecionar para departamentos.php com a mensagem de erro
      header("Location: departamentos.php?mensagem=Erro ao remover usuário do departamento");
      exit; // Adicionar o exit para interromper o processamento da página
    }
  }

  // Verificar se o botão "Adicionar" foi clicado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar'])) {
    $userID = $_POST['adicionar'];
    $departamentoID = $_SESSION['departamento-id'];
  
    // Atualizar a coluna IDdepartamento para o valor de $departamentoID no banco de dados para o usuário com o ID especificado ($userID)
    $sqlUpdate = "UPDATE users SET IDdepartamento = $departamentoID WHERE ID = $userID";
    $resultado = mysqli_query($conn, $sqlUpdate);
  
    // Verificar se a atualização foi bem-sucedida
    if ($resultado) {
      // Redirecionar para departamentos.php com a mensagem de sucesso
      header("Location: departamentos.php?mensagem=Usuário adicionado ao departamento com sucesso!");
      exit; // Adicionar o exit para interromper o processamento da página
    } else {
      // Redirecionar para departamentos.php com a mensagem de erro
      header("Location: departamentos.php?mensagem=Erro ao adicionar usuário ao departamento");
      exit; // Adicionar o exit para interromper o processamento da página
    }
  }
?>
