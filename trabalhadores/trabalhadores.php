<?php
include("../database/database.php"); // Incluir a base de dados!
session_start(); // Iniciar a sessão

// Verificar se o usuário está autenticado
if (!isset($_SESSION["user_id"])) {
  header("Location: ../login.php");
  exit();
}

// Obter o ID do usuário atualmente autenticado
$userId = $_SESSION["user_id"];

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Recuperar os dados do formulário
  $iban1 = $_POST['iban1'];
  $telm1 = $_POST['telm1'];
  $tel1 = $_POST['tel1'];
  $morada1 = $_POST['morada1'];
  $localidade1 = $_POST['localidade1'];
  $cp1 = $_POST['cp1'];
  $funcao1 = $_POST['funcao1'];
  $estado1 = $_POST['estado1'];

  // Converter o valor booleano para um valor numérico para atualizar na base de dados
  $estadoNum = ($estado1 == 'ativo') ? 1 : 0;

  // Atualizar os dados na base de dados apenas para o ID de usuário correspondente
  $updateQuery = "UPDATE users SET 
                  IBAN = '$iban1',
                  Tel = '$telm1',
                  Telf = '$tel1',
                  Morada = '$morada1',
                  Localidade = '$localidade1',
                  CodigoPostal = '$cp1',
                  Funcao = '$funcao1',
                  Estado = $estadoNum
                  WHERE id = $userId"; // Atualiza apenas para o ID de usuário correspondente
  
  if (mysqli_query($conn, $updateQuery)) {
    echo "Dados atualizados com sucesso.";
  } else {
    echo "Erro ao atualizar os dados: " . mysqli_error($conn);
  }
}

// Consultar a base de dados para obter os dados do trabalhador correspondente ao ID de usuário
$query = "SELECT * FROM users WHERE id = $userId"; // Consulta apenas para o ID de usuário correspondente
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Recuperar os dados do trabalhador
$nome1 = $row['username'];
$iban1 = $row['IBAN'];
$telm1 = $row['Tel'];
$tel1 = $row['Telf'];
$morada1 = $row['Morada'];
$localidade1 = $row['Localidade'];
$cp1 = $row['CodigoPostal'];
$funcao1 = $row['Funcao'];
$estado1 = ($row['Estado'] == 1) ? 'ativo' : 'desativo';


// Consultar a base de dados para obter os salários detalhados, incluindo o custo do IRS, do utilizador correspondente ao ID de usuário
$salariosDetalhadosQuery = "SELECT Ano, Mes, SalBruto, SalLiquido, SegSocial, SubAlim, IRS FROM salarios WHERE ID = $userId"; // Consulta apenas os salários detalhados do utilizador logado
$salariosDetalhadosResult = mysqli_query($conn, $salariosDetalhadosQuery);



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trabalhadores</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h1>Trabalhadores</h1>
    
    <form method="POST" action="trabalhadores.php">
      <table class="table">
        <thead>
          <tr>
            <th>Nome</th>
            <th>IBAN</th>
            <th>Telemóvel</th>
            <th>Telefone</th>
            <th>Morada</th>
            <th>Localidade</th>
            <th>Código Postal</th>
            <th>Função</th>
            <th>Estado</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo $nome1; ?></td>
            <td>
              <input type="text" class="form-control" name="iban1" value="<?php echo $iban1; ?>">
            </td>
            <td>
              <input type="text" class="form-control" name="telm1" value="<?php echo $telm1; ?>">
            </td>
            <td>
              <input type="text" class="form-control" name="tel1" value="<?php echo $tel1; ?>">
            </td>
            <td>
              <input type="text" class="form-control" name="morada1" value="<?php echo $morada1; ?>">
            </td>
            <td>
              <input type="text" class="form-control" name="localidade1" value="<?php echo $localidade1; ?>">
            </td>
            <td>
              <input type="text" class="form-control" name="cp1" value="<?php echo $cp1; ?>">
            </td>
            <td>
              <input type="text" class="form-control" name="funcao1" value="<?php echo $funcao1; ?>">
            </td>
            <td>
              <select class="form-select" name="estado1">
                <option value="ativo" <?php if ($estado1 == 'ativo') echo 'selected'; ?>>Ativo</option>
                <option value="desativo" <?php if ($estado1 == 'desativo') echo 'selected'; ?>>Desativo</option>
              </select>
            </td>
            <td>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </td>
          </tr>
          
          <!-- Adicione mais linhas para outros trabalhadores -->
          
        </tbody>
      </table>
    </form>
  </div>

  <div class="container mt-5">
  <h1>Tabela de Salários do Utilizador</h1>
  <table class="table">
  <thead>
      <tr>
        <th class="ano">Ano</th>
        <th class="mes">Mês</th>
        <th class="parcela">Bruto</th>
        <th class="parcela">Líquido</th>
        <th class="parcela">S.S</th>
        <th class="parcela">IRS</th>
        <th class="parcela">Alimentação</th>
        
      </tr>
    </thead>
    <tbody>
      <?php
        // Loop para exibir os dados de salários detalhados na tabela
        while ($salarioDetalhadoRow = mysqli_fetch_assoc($salariosDetalhadosResult)) {
          echo "<tr>";
          echo "<td class='text-center'>" . $salarioDetalhadoRow['Ano'] . "</td>";
          echo "<td class='text-center'>" . $salarioDetalhadoRow['Mes'] . "</td>";
          echo "<td class='text-end'>" . $salarioDetalhadoRow['SalBruto'] . "</td>";
          echo "<td class='text-end'>" . $salarioDetalhadoRow['SalLiquido'] . "</td>";
          echo "<td class='text-end'>" . $salarioDetalhadoRow['SegSocial'] . "</td>";
          echo "<td class='text-end'>" . $salarioDetalhadoRow['IRS'] . "</td>";
          echo "<td class='text-end'>" . $salarioDetalhadoRow['SubAlim'] . "</td>";
          
          echo "</tr>";
        }
      ?>
    </tbody>
  </table>
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
