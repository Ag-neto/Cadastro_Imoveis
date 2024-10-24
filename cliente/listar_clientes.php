<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de clientes</title>
    <link rel="stylesheet" href="../style/listar_cliente.css">
</head>

<body>
    <header>
        <h1>Lista de Clientes</h1>
    </header>

    <section class="form-section">
        <h2>Clientes</h2>
        <form id="buscar-cliente-form" method="GET" action="listar_clientes.php">
            <div class="form-group">
                <label for="busca">Buscar Clientes:</label>
                <input type="text" id="busca" name="busca" placeholder="Digite o NOME ou CPF">
            </div>

            <button type="submit">Buscar</button>
            <a href="../index.php" class="btn-voltar">Voltar</a>
            <a href="cadastro_cliente.php" class="btn-criar_cliente">Cadastrar Cliente</a>
        </form>
    </section>

    <section class="clientes-lista">
        <h2>Clientes Cadastrados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>CPF</th>
                    <th>Endereco</th>
                    <th>Data De Nascimento</th>
                    <th>Detalhes</th>
                </tr>
            </thead>
            <tbody>
                <?php

                // Verifica se há uma busca
                $busca = isset($_GET['busca']) ? $_GET['busca'] : '';
                $busca = $conn->real_escape_string($busca); // Evita SQL Injection

                // Prepara a consulta SQL
                $sql = "SELECT * FROM cliente";

                // Adiciona condição de busca se houver
                if (!empty($busca)) {
                    $sql .= " WHERE nome_cliente LIKE '%$busca%' 
                               OR cpf_numero LIKE '%$busca%'";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Loop para listar as clientes
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['idcliente'] . '</td>'; // Supondo que o ID da cliente seja 'id_cliente'
                        echo '<td>' . $row['nome_cliente'] . '</td>';
                        echo '<td>' . $row['telefone'] . '</td>';
                        echo '<td>' . $row['cpf_numero'] .'</td>';
                        echo '<td>' . $row['endereco'] . '</td>';
                        echo '<td>' . date('d/m/Y', strtotime($row['data_nascimento'])) . '</td>';
                        echo '<td><a href="detalhes_cliente.php?id=' . $row['idcliente'] . '">Ver Detalhes</a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">Nenhum cliente encontrado.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>

    <script src="../scripts/script_clientes.js"></script>
</body>

</html>
