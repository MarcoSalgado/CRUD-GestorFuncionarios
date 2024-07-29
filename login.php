<?php
include("database/database.php"); // Inclua a base de dados!
session_start(); // Iniciar a sessão

// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupere os dados do formulário de login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulte o banco de dados para verificar se as credenciais são válidas
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    // Verifique se o usuário foi encontrado no banco de dados
    if (mysqli_num_rows($result) > 0) {
        // Recupere os dados do usuário
        $row = mysqli_fetch_assoc($result);
        $isAdmin = $row['Admin'];
        $userId = $row['ID']; // Obtenha o ID do usuário da coluna 'id'

        if ($isAdmin == true) {
            // Usuário autenticado com sucesso e é um administrador
            $_SESSION["perms"] = "full";
            $_SESSION["user_id"] = $userId; // Armazene o ID do usuário na sessão
            header("Location: admin/admin.php");
            exit();
        } if ($isAdmin == false) {
            // Usuário autenticado com sucesso, mas não é um administrador
            $_SESSION["perms"] = "half";
            $_SESSION["user_id"] = $userId; // Armazene o ID do usuário na sessão
            header("Location: trabalhadores/trabalhadores.php");
            exit();
        }
    } else {
        // Credenciais inválidas
        echo "Nome de usuário ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página de Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card" style="width: 18rem;">
      <div class="card-body">
        <h5 class="card-title">Login</h5>
        <form method="POST" action="login.php">
          <div class="mb-3">
            <label for="username" class="form-label">Utilizador</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Digite o Utilizador" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Digite a Senha" required>
          </div>
          <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
