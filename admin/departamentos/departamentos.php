<?php
include("../../database/database.php"); // incluir a base de dados!
session_start(); // Iniciar a sessão

if ($_SESSION["perms"] != "full") {
  // Manda para a página de login quem tentar entrar nesta página sem perms de admin
  header("Location: ../../login.php");
  exit;
}

// Verificar se o botão "Remover" foi clicado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remover'])) {
  $userID = $_POST['remover'];

  // Atualizar a coluna IDdepartamento para 0 no banco de dados para o usuário com o ID especificado ($userID)
  $sqlUpdate = "UPDATE users SET IDdepartamento = 0 WHERE ID = $userID";
  mysqli_query($conn, $sqlUpdate);

  // Redirecionar para departamentos.php com a mensagem de sucesso
  header("Location: departamentos.php?mensagem=Usuário removido do departamento com sucesso!");
  exit;
}

// Verificar se o botão "Adicionar" foi clicado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar'])) {
  $userID = $_POST['adicionar'];
  $departamentoID = $_SESSION['departamento-id'];

  // Atualizar a coluna IDdepartamento para o valor de $departamentoID no banco de dados para o usuário com o ID especificado ($userID)
  $sqlUpdate = "UPDATE users SET IDdepartamento = $departamentoID WHERE ID = $userID";
  mysqli_query($conn, $sqlUpdate);

  // Redirecionar para departamentos.php com a mensagem de sucesso
  header("Location: departamentos.php?mensagem=Usuário adicionado ao departamento com sucesso!");
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Departamentos</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <a class="btn btn-primary" href="../admin.php">Home page</a>
    </div>
  <div class="container mt-4">
    <h1 class="mb-4">Criar Departamento</h1>

    <form action="func.php" method="post">
      <div class="form-row">
        <div class="col-9">
          <input type="text" class="form-control custom-input" name="departamento" placeholder="Digite o nome do departamento">
        </div>
        <div class="col-3">
          <button type="submit" class="btn btn-primary custom-button">Criar</button>
        </div>
      </div>
    </form>

    <h1 class="mt-5">Eliminar Departamento</h1>
    <form action="func.php" method="post">
      <div class="form-row">
        <div class="col-9">
          <select class="form-control custom-input" name="departamento-eliminar">
            <?php
            // Obter os departamentos da tabela "departamentos"
            $sqlDelete = "SELECT IDdepartamento, Nomedepartamento FROM departamentos";
            $resultado = mysqli_query($conn, $sqlDelete);

            // Exibir cada departamento como uma opção na dropdown
            while ($row = mysqli_fetch_assoc($resultado)) {
              echo '<option value="' . $row['IDdepartamento'] . '">' . $row['Nomedepartamento'] . '</option>';
            }
            ?>
          </select>
        </div>
        <div class="col-3">
          <button type="submit" class="btn btn-danger custom-button">Eliminar</button>
        </div>
      </div>
    </form>

    <!-- Exibir mensagem de sucesso -->
    <?php if (isset($_GET['mensagem'])): ?>
      <div class="success-bar mt-4">
        <span class="success-message"><?php echo $_GET['mensagem']; ?></span>
      </div>
    <?php endif; ?>

    <!-- Dropdown para alterar departamentos -->
    <h1 class="mt-5">Alterar Departamentos</h1>
    <form action="func.php" method="post">
      <div class="form-row">
        <div class="col-9">
          <select class="form-control custom-input" name="departamento-alterar">
            <?php
            // Obter os departamentos da tabela "departamentos"
            $sqlAlterarDepartamento = "SELECT IDdepartamento, Nomedepartamento FROM departamentos";
            $resultado = mysqli_query($conn, $sqlAlterarDepartamento);

            // Exibir cada departamento como uma opção na dropdown
            while ($row = mysqli_fetch_assoc($resultado)) {
              echo '<option value="' . $row['IDdepartamento'] . '">' . $row['Nomedepartamento'] . '</option>';
            }
            ?>
          </select>
        </div>
        <div class="col-3">
          <button type="submit" class="btn btn-primary custom-button">Alterar</button>
        </div>
      </div>
    </form>


    <?php if (isset($_GET['departamento-id'])): ?>
      

      <!-- Tabela de usuários do departamento selecionado -->
      <?php
      $departamentoID = $_GET['departamento-id'];
      $sqlUsuarios = "SELECT users.ID, users.username, users.IDdepartamento, departamentos.Nomedepartamento AS departamento
                      FROM users
                      LEFT JOIN departamentos ON users.IDdepartamento = departamentos.IDdepartamento
                      WHERE users.IDdepartamento = $departamentoID OR users.IDdepartamento = 0";
      $resultadoUsuarios = mysqli_query($conn, $sqlUsuarios);
      ?>

      <h2 class="mt-4">Usuários do Departamento</h2>
      <form action="func.php" method="post">
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Departamento</th>
              <th>Ação</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($usuario = mysqli_fetch_assoc($resultadoUsuarios)): ?>
              <tr>
                <td><?php echo $usuario['ID']; ?></td>
                <td><?php echo $usuario['username']; ?></td>
                <td><?php echo $usuario['departamento'] ?? 'Sem departamento'; ?></td>
                <td>
                  <?php if ($usuario['IDdepartamento'] == $departamentoID): ?>
                    <button type="submit" name="remover" value="<?php echo $usuario['ID']; ?>">Remover</button>
                  <?php else: ?>
                    <button type="submit" name="adicionar" value="<?php echo $usuario['ID']; ?>">Adicionar</button>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </form>
    <?php endif; ?>

 <!-- Custos de Departamento -->
<h1 class="mt-5">Custos de Departamento</h1>
<form method="post">
  <div class="form-row">
    <div class="col-9">
      <select class="form-control custom-input" name="departamento-custos">
        <?php
        // Obter os departamentos da tabela "departamentos"
        $sqlDepartamentos = "SELECT IDdepartamento, Nomedepartamento FROM departamentos";
        $resultadoDepartamentos = mysqli_query($conn, $sqlDepartamentos);

        // Exibir cada departamento como uma opção na dropdown
        while ($departamento = mysqli_fetch_assoc($resultadoDepartamentos)) {
          echo '<option value="' . $departamento['IDdepartamento'] . '">' . $departamento['Nomedepartamento'] . '</option>';
        }
        ?>
      </select>
    </div>
    <div class="col-3">
      <button type="submit" class="btn btn-primary custom-button" name="selecionar-custos">Selecionar</button>
    </div>
  </div>
</form>

<?php

function calcularCustoTotalSalarios($conn, $departamentoID) {
  $sqlSalarios = "SELECT SUM(CustoTotal) AS custoTotal FROM salarios WHERE ID IN (SELECT ID FROM users WHERE IDdepartamento = $departamentoID)";
  $resultadoSalarios = mysqli_query($conn, $sqlSalarios);
  $rowCustoTotal = mysqli_fetch_assoc($resultadoSalarios);
  return $rowCustoTotal['custoTotal'];
}

// Verificar se foi selecionado um departamento para mostrar os usuários
if (isset($_POST['selecionar-custos']) && isset($_POST['departamento-custos'])) {
  $departamentoID = $_POST['departamento-custos'];

  // Obter os usuários do departamento selecionado
  $sqlUsuariosCustos = "SELECT users.ID, users.username, users.IDdepartamento, departamentos.Nomedepartamento AS departamento
                        FROM users
                        LEFT JOIN departamentos ON users.IDdepartamento = departamentos.IDdepartamento
                        WHERE users.IDdepartamento = $departamentoID";
  $resultadoUsuariosCustos = mysqli_query($conn, $sqlUsuariosCustos);

  // Calcular o custo total do departamento chamando a função
  $custoTotalDepartamento = calcularCustoTotalSalarios($conn, $departamentoID);
?>

  <h2 class="mt-10 mb-10">Usuários do Departamento Selecionado</h2>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Departamento</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($usuarioCustos = mysqli_fetch_assoc($resultadoUsuariosCustos)): ?>
        <tr>
          <td><?php echo $usuarioCustos['ID']; ?></td>
          <td><?php echo $usuarioCustos['username']; ?></td>
          <td><?php echo $usuarioCustos['departamento']; ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <h3>Custo Total do Departamento: <?php echo $custoTotalDepartamento; ?></h3>
<?php
}
?>