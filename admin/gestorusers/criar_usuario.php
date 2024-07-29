<?php
include("../../database/database.php"); // Incluir a base de dados!

include("func.php");

if ($_SESSION["perms"] != "full") {
    // Manda para a página de login quem tentar entrar nesta página sem perms de admin
    header("Location: ../../login.php");
    exit;
  }
// Função para criar um novo utilizador na tabela "users"
function criarUtilizador($username, $data_nasc, $nif, $iban, $tel, $telf, $email, $morada, $localidade, $codigo_postal, $funcao, $estado, $admin, $password)
{
    global $conn;

    // Preparar e executar a consulta para inserir um novo utilizador
    $sql = "INSERT INTO users (username, DataNasc, NIF, IBAN, Tel, Telf, Email, Morada, Localidade, CodigoPostal, Funcao, Estado, Admin, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssss", $username, $data_nasc, $nif, $iban, $tel, $telf, $email, $morada, $localidade, $codigo_postal, $funcao, $estado, $admin, $password);
    $resultado = $stmt->execute();

    // Fechar o statement
    $stmt->close();

    return $resultado;
}

// Verificar se o formulário foi submetido para criar um novo utilizador
if (isset($_POST['criar_usuario'])) {
    $username = $_POST['username'];
    $data_nasc = $_POST['data_nasc'];
    $nif = $_POST['nif'];
    $iban = $_POST['iban'];
    $tel = $_POST['tel'];
    $telf = $_POST['telf'];
    $email = $_POST['email'];
    $morada = $_POST['morada'];
    $localidade = $_POST['localidade'];
    $codigo_postal = $_POST['codigo_postal'];
    $funcao = $_POST['funcao'];
    $estado = $_POST['estado'];
    $admin = $_POST['admin'];
    $password = $_POST['password'];

    // Criar o novo utilizador
    $criacao_sucesso = criarUtilizador($username, $data_nasc, $nif, $iban, $tel, $telf, $email, $morada, $localidade, $codigo_postal, $funcao, $estado, $admin, $password);

    header("Location: gestorusers.php");
}
?>