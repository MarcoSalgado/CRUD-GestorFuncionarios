<?php
include("../../database/database.php"); // Incluir a base de dados!
session_start(); // Iniciar a sessão
if ($_SESSION["perms"] != "full") {
    // Manda para a página de login quem tentar entrar nesta página sem perms de admin
    header("Location: ../../login.php");
    exit;
}

// Variável para armazenar a mensagem de erro ou sucesso
$mensagem = "";

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se todos os campos foram preenchidos
    if (
        isset($_POST["processar_salario"]) &&
        isset($_POST["month"]) &&
        isset($_POST["year"]) &&
        isset($_POST["salario_bruto"])
    ) {
        // Recuperar os valores enviados pelo formulário
        $userId = $_POST["processar_salario"];
        $month = $_POST["month"];
        $year = $_POST["year"];
        $salarioBruto = $_POST["salario_bruto"];

        // Verificar se o mês e o ano são válidos (entre 1 e 12 para mês e maior que 1900 para ano)
        if (!is_numeric($month) || !is_numeric($year) || $month < 1 || $month > 12 || $year < 1900) {
            // Definir a mensagem de erro
            $mensagem = "Mês e ano inválidos!";
        } else {
            // Verificar se já existe um registro para o mesmo usuário, ano e mês na tabela "salarios"
            $sqlVerificarDuplicata = "SELECT * FROM salarios WHERE ID = '$userId' AND Mes = '$month' AND Ano = '$year'";
            $resultadoVerificar = mysqli_query($conn, $sqlVerificarDuplicata);
            $numLinhas = mysqli_num_rows($resultadoVerificar);

            // Se já existe um registro para o mesmo usuário, ano e mês, definir a mensagem de erro
            if ($numLinhas > 0) {
                // Definir a mensagem de erro
                $mensagem = "Já existe um processamento salarial para o mesmo mês e ano!";
            } else {
                // Calcular o valor da segurança social
                $segurancaSocial = $salarioBruto * 0.11;

                // Calcular o valor da segurança social pago pela empresa
                $SSEmpresa = $salarioBruto * 0.13;

                // Calcular o valor do IRS com base nos termos fornecidos
                if ($salarioBruto <= 1000) {
                    $IRS = $salarioBruto * 0.09;
                } elseif ($salarioBruto <= 1750) {
                    $IRS = $salarioBruto * 0.13;
                } else {
                    $IRS = $salarioBruto * 0.16;
                }

                // Salário líquido após dedução do IRS e segurança social
                $salarioLiquido = $salarioBruto - $segurancaSocial - $IRS;

                //Custo total para a empresa
                $CustoTotal = $salarioBruto + $SSEmpresa;

                // Calcular o valor do subsídio de alimentação (5.25 vezes o número de dias úteis do mês)
                // Supondo que um mês tem 22 dias úteis:
                $SubAlim = 5.25 * 22;

                // Salário líquido final com o valor do subsídio de alimentação
                $salarioLiquido += $SubAlim;



                // Obter o username associado ao ID selecionado
                $sqlObterUsername = "SELECT username FROM users WHERE ID = '$userId'";
                $resultadoUsername = mysqli_query($conn, $sqlObterUsername);
                $rowUsername = mysqli_fetch_assoc($resultadoUsername);
                $username = $rowUsername['username'];

                // Inserir um registro na tabela "salarios"
                $sqlInserirSalario = "INSERT INTO salarios (ID, Nome, SalBruto, SegSocial, IRS, SubAlim, Mes, Ano, SalLiquido, SSEmpresa, CustoTotal) VALUES ('$userId', '$username', '$salarioBruto', '$segurancaSocial', '$IRS', '$SubAlim', '$month', '$year', '$salarioLiquido', '$SSEmpresa', '$CustoTotal')";
                mysqli_query($conn, $sqlInserirSalario);

                // Definir a mensagem de sucesso
                $mensagem = "Processamento salarial realizado com sucesso!";
            }
        }
    } else {
        // Caso algum campo não tenha sido preenchido, definir a mensagem de erro
        $mensagem = "Por favor, preencha todos os campos do formulário.";
    }
}
?>
