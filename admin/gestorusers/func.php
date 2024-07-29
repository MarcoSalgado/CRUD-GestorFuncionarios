<?php
include("../../database/database.php"); // incluir a base de dados!
session_start(); // Iniciar a sessão


// Função para obter os utilizadores da tabela "users"
function getUtilizadores()
{
    global $conn;

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    $utilizadores = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $utilizadores[] = $row;
        }
    }

    return $utilizadores;
}



// Função para eliminar um utilizador da tabela "users"
function eliminarUtilizador($id)
{
    global $conn;

    // Verificar se o ID do utilizador é válido
    if (!is_numeric($id) || $id <= 0) {
        return false;
    }

    // Preparar e executar a consulta para eliminar o utilizador
    $sql = "DELETE FROM users WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $resultado = $stmt->execute();
    echo $resultado ? "Utilizador eliminado com sucesso." : "Erro ao eliminar o utilizador.";

    // Fechar o statement
    $stmt->close();

    return $resultado;
}

// Verificar se o botão "Eliminar" foi clicado e realizar a eliminação
if (isset($_POST['eliminar_usuario'])) {
    $id_usuario_a_eliminar = $_POST['eliminar_usuario'];
    eliminarUtilizador($id_usuario_a_eliminar);
}


// Função para obter um utilizador pelo ID
function getUtilizadorById($id)
{
    global $conn;

    // Verificar se o ID do utilizador é válido
    if (!is_numeric($id) || $id <= 0) {
        return false;
    }

    $sql = "SELECT * FROM users WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

// Função para atualizar os dados de um utilizador na tabela "users"
function atualizarUtilizador($id, $novo_nome, $nova_data_nasc, $novo_nif, $novo_iban, $novo_telm, $novo_tel, $novo_email, $nova_morada, $nova_localidade, $novo_cp, $nova_funcao, $novo_estado)
{
    global $conn;

    // Verificar se o ID do utilizador é válido
    if (!is_numeric($id) || $id <= 0) {
        return false;
    }

    // Preparar e executar a consulta para atualizar o utilizador
    $sql = "UPDATE users SET username = ?, DataNasc = ?, NIF = ?, IBAN = ?, Tel = ?, Telf = ?, Email = ?, Morada = ?, Localidade = ?, CodigoPostal = ?, Funcao = ?, Estado = ? WHERE ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssi", $novo_nome, $nova_data_nasc, $novo_nif, $novo_iban, $novo_telm, $novo_tel, $novo_email, $nova_morada, $nova_localidade, $novo_cp, $nova_funcao, $novo_estado, $id);
    $resultado = $stmt->execute();

    // Fechar o statement
    $stmt->close();

    return $resultado;
}

?>