<!DOCTYPE html>
<html>
<head>
    <title>Gestão de Utilizadores</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        
        .title-column {
            flex: 1;
        }

        .home-button {
            margin-left: auto;
        }

        .table-max-width td {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .btn-eliminar {
            background-color: red;
            color: white;
        }
        .btn-editar {
            background-color: blue;
            color: white;
        }

        .td-buttons {
            white-space: nowrap;
        }
    </style>
</head>
<body>
<div class="container mt-4 ml-5">
    <div class="d-flex align-items-center">
        <div class="title-column">
            <h1>Gestão de Utilizadores</h1>
        </div>
        <div class="home-button">
            <a class="btn btn-primary" href="../admin.php">Home page</a>
        </div>
    </div>
    <!-- Tabela de Utilizadores -->
    <h2>Tabela de Utilizadores</h2>
    <table class="table table-striped table-max-width">
        <thead>
            <tr>
                <!-- Coluna para os botões -->
                <th>Ações</th>
                <th>Nome</th>
                <th>Data Nasc</th>
                <th>NIF</th>
                <th>IBAN</th>
                <th>Telm</th>
                <th>Tel</th>
                <th>Email</th>
                <th>Morada</th>
                <th>Localidade</th>
                <th>Código Postal</th>
                <th>Departamento</th>
                <th>Função</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Incluindo o arquivo func.php
            include("func.php");

            // Obtendo os utilizadores da tabela "users"
            $utilizadores = getUtilizadores();

            // Verificando se existem utilizadores
            if (!empty($utilizadores)) {
                foreach ($utilizadores as $utilizador) {
                    echo "<tr>";
                    // Coluna com os botões "Eliminar" e "Editar"
                    echo '<td class="td-buttons">
                            <form method="post">
                                <button type="submit" class="btn btn-eliminar" name="eliminar_usuario" value="'.$utilizador['ID'].'">Eliminar</button>
                            </form>
                            <a href="editar_usuario.php?id='.$utilizador['ID'].'" class="btn btn-editar">Editar</a>
                          </td>';
                    echo "<td>".$utilizador['username']."</td>";
                    echo "<td>".$utilizador['DataNasc']."</td>";
                    echo "<td>".$utilizador['NIF']."</td>";
                    echo "<td>".$utilizador['IBAN']."</td>";
                    echo "<td>".$utilizador['Tel']."</td>";
                    echo "<td>".$utilizador['Telf']."</td>";
                    echo "<td>".$utilizador['Email']."</td>";
                    echo "<td>".$utilizador['Morada']."</td>";
                    echo "<td>".$utilizador['Localidade']."</td>";
                    echo "<td>".$utilizador['CodigoPostal']."</td>";
                    echo "<td>".$utilizador['IDdepartamento']."</td>";
                    echo "<td>".$utilizador['Funcao']."</td>";
                    echo "<td>".$utilizador['Estado']."</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='14'>Nenhum utilizador encontrado na base de dados.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!--formulário para criar um novo usuário -->
<div class="container mt-4 ml-5">
    <h2>Criar Novo Utilizador</h2>
    <form method="post" action="criar_usuario.php">
        <div class="form-group">
            <label for="username">Nome:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="data_nasc">Data Nascimento:</label>
            <input type="date" class="form-control" id="data_nasc" name="data_nasc" required>
        </div>
        <div class="form-group">
            <label for="nif">NIF:</label>
            <input type="text" class="form-control" id="nif" name="nif" required>
        </div>
        <button type="submit" class="btn btn-primary" name="criar_usuario">Criar Utilizador</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
