<?php
include("../../database/database.php"); // Incluir a base de dados!

include("func.php");

if ($_SESSION["perms"] != "full") {
    // Manda para a página de login quem tentar entrar nesta página sem perms de admin
    header("Location: ../../login.php");
    exit;
  }

// Verificar se o parâmetro 'id' foi passado na URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario_editar = $_GET['id'];

    // Obter os dados do utilizador pelo ID
    $utilizador = getUtilizadorById($id_usuario_editar);
}

// Verificar se o formulário foi submetido para atualização
if (isset($_POST['atualizar_usuario'])) {
    // Obter os dados do formulário
    $id_usuario = $_POST['id'];
    $novo_nome = $_POST['novo_nome'];
    $nova_data_nasc = $_POST['nova_data_nasc'];
    $novo_nif = $_POST['novo_nif'];
    $novo_iban = $_POST['novo_iban'];
    $novo_telm = $_POST['novo_telm'];
    $novo_tel = $_POST['novo_tel'];
    $novo_email = $_POST['novo_email'];
    $nova_morada = $_POST['nova_morada'];
    $nova_localidade = $_POST['nova_localidade'];
    $novo_cp = $_POST['novo_cp'];
    $nova_funcao = $_POST['nova_funcao'];
    $novo_estado = $_POST['novo_estado'];
    
    // Atualizar os dados do utilizador na base de dados
    $atualizacao_sucesso = atualizarUtilizador($id_usuario, $novo_nome, $nova_data_nasc, $novo_nif, $novo_iban, $novo_telm, $novo_tel, $novo_email, $nova_morada, $nova_localidade, $novo_cp, $nova_funcao, $novo_estado);


}

if (isset($_POST['voltar'])) {
    header("Location: gestorusers.php");

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Utilizador</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4 ml-5">
    <h1>Editar Utilizador</h1>

    <?php
    if (isset($atualizacao_sucesso)) {
        if ($atualizacao_sucesso) {
            echo '<div class="alert alert-success">Dados do utilizador atualizados com sucesso!</div>';
        } else {
            echo '<div class="alert alert-danger">Erro ao atualizar os dados do utilizador.</div>';
        }
    }
    ?>

    <!-- Formulário de Edição de Utilizador -->
    <?php if (isset($utilizador) && $utilizador !== false): ?>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $utilizador['ID']; ?>">
            <div class="form-group">
                <label for="novo_nome">Nome:</label>
                <input type="text" class="form-control" id="novo_nome" name="novo_nome" value="<?php echo $utilizador['username']; ?>">
            </div>
            <div class="form-group">
                <label for="nova_data_nasc">Data Nascimento:</label>
                <input type="date" class="form-control" id="nova_data_nasc" name="nova_data_nasc" value="<?php echo $utilizador['DataNasc']; ?>">
            </div>
            <div class="form-group">
                <label for="novo_nif">NIF:</label>
                <input type="text" class="form-control" id="novo_nif" name="novo_nif" value="<?php echo $utilizador['NIF']; ?>">
            </div>
            <div class="form-group">
                <label for="novo_iban">IBAN:</label>
                <input type="text" class="form-control" id="novo_iban" name="novo_iban" value="<?php echo $utilizador['IBAN']; ?>">
            </div>
            <div class="form-group">
                <label for="novo_telm">Telm:</label>
                <input type="text" class="form-control" id="novo_telm" name="novo_telm" value="<?php echo $utilizador['Tel']; ?>">
            </div>
            <div class="form-group">
                <label for="novo_tel">Tel:</label>
                <input type="text" class="form-control" id="novo_tel" name="novo_tel" value="<?php echo $utilizador['Telf']; ?>">
            </div>
            <div class="form-group">
                <label for="novo_email">Email:</label>
                <input type="email" class="form-control" id="novo_email" name="novo_email" value="<?php echo $utilizador['Email']; ?>">
            </div>
            <div class="form-group">
                <label for="nova_morada">Morada:</label>
                <input type="text" class="form-control" id="nova_morada" name="nova_morada" value="<?php echo $utilizador['Morada']; ?>">
            </div>
            <div class="form-group">
                <label for="nova_localidade">Localidade:</label>
                <input type="text" class="form-control" id="nova_localidade" name="nova_localidade" value="<?php echo $utilizador['Localidade']; ?>">
            </div>
            <div class="form-group">
                <label for="novo_cp">Código Postal:</label>
                <input type="text" class="form-control" id="novo_cp" name="novo_cp" value="<?php echo $utilizador['CodigoPostal']; ?>">
            </div>
            <div class="form-group">
                <label for="nova_funcao">Função:</label>
                <input type="text" class="form-control" id="nova_funcao" name="nova_funcao" value="<?php echo $utilizador['Funcao']; ?>">
            </div>
            <div class="form-group">
                <label for="novo_estado">Estado:</label>
                <input type="text" class="form-control" id="novo_estado" name="novo_estado" value="<?php echo $utilizador['Estado']; ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="atualizar_usuario">Atualizar</button>
            <button type="submit" class="btn btn-primary" name="voltar">Voltar</button>
            
        </form>
    <?php else: ?>
        <div class="alert alert-danger">Utilizador não encontrado.</div>
    <?php endif; ?>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>