<?php
include("func.php");

if ($_SESSION["perms"] != "full") {
    // Manda para a página de login quem tentar entrar nesta página sem perms de admin
    header("Location: ../../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Processamento de Salários</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Selecione o usuário e informe os dados para processar o salário</h1>
            <div class="home-button">
                <a class="btn btn-primary" href="../admin.php">Home page</a>
            </div>
        </div>

        <!-- Exibir mensagem de erro ou sucesso, se houver -->
        <?php if ($mensagem): ?>
            <div class="alert <?php echo $mensagem == "Processamento salarial realizado com sucesso!" ? "alert-success" : "alert-danger"; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <!-- Dropdown para selecionar o usuário pelo username -->
            <form method="post">
                <!-- Restante do código do formulário -->
                <label for="user-username">Selecione o usuário pelo Username:</label>
                <select class="form-control custom-input" name="processar_salario">
                    <?php
                    // Obter os users da tabela "users"
                    $sqlProcessar_salario = "SELECT ID, username FROM users";
                    $resultado = mysqli_query($conn, $sqlProcessar_salario);

                    // Exibir cada user como uma opção na dropdown
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo '<option value="' . $row['ID'] . '">' . $row['username'] . '</option>';
                    }
                    ?>
                </select>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <!-- Input para o mês -->
                        <label for="month">Selecione o mês:</label>
                        <input type="number" class="form-control" name="month" min="1" max="12">
                    </div>

                    <div class="form-group col-md-6">
                        <!-- Input para o ano -->
                        <label for="year">Selecione o ano:</label>
                        <input type="number" class="form-control" name="year" min="1900" max="2100">
                    </div>
                </div>

                <div class="form-group">
                    <!-- Input para o salário bruto -->
                    <label for="salario-bruto">Informe o salário bruto:</label>
                    <input type="number" class="form-control" name="salario_bruto" step="0.01">
                </div>

                <!-- Botão para processar o salário -->
                <button type="submit" class="btn btn-primary">Processar Salário</button>
            </form>
        </div>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
