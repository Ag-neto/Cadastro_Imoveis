<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de inquilinos</title>
    <link rel="stylesheet" href="../style/listar_inquilino.css">
</head>

<body>
    <header>
        <h1>Lista de Inquilinos</h1>
    </header>

    <section class="form-section">
        <h2>Inquilinos</h2>
        <form id="buscar-inquilino-form" method="GET" action="listar_inquilinos.php">
            <div class="form-group">
                <label for="busca">Buscar Inquilinos:</label>
                <input type="text" id="busca" name="busca" placeholder="Digite o NOME ou CPF">
            </div>

            <button type="submit">Buscar</button>
            <a href="../index.php" class="btn-voltar">Voltar</a>
            <a href="cadastro_inquilo.php" class="btn-criar_inquilino">Cadastrar Inquilino</a>
        </form>
    </section>

    <section class="inquilinos-lista">
        <h2>Inquilinos Cadastrados</h2>
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
                require_once "../conexao/conexao.php";

                // Verifica se há uma busca
                $busca = isset($_GET['busca']) ? $_GET['busca'] : '';
                $busca = $conn->real_escape_string($busca); // Evita SQL Injection

                // Prepara a consulta SQL
                $sql = "SELECT * FROM inquilino";

                // Adiciona condição de busca se houver
                if (!empty($busca)) {
                    $sql .= " WHERE nome_inquilino LIKE '%$busca%' 
                               OR cpf_numero LIKE '%$busca%'";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Loop para listar as inquilinos
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['idinquilino'] . '</td>'; // Supondo que o ID da inquilino seja 'id_inquilino'
                        echo '<td>' . $row['nome_inquilino'] . '</td>';
                        echo '<td>' . $row['telefone'] . '</td>';
                        echo '<td>' . $row['cpf_numero'] .'</td>';
                        echo '<td>' . $row['endereco'] . '</td>';
                        echo '<td>' . date('d/m/Y', strtotime($row['data_nascimento'])) . '</td>';
                        echo '<td><a href="detalhes_inquilino.php?id=' . $row['idinquilino'] . '">Ver Detalhes</a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">Nenhum inquilino encontrado.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>

    <script src="../scripts/script_inquilinos.js"></script>
</body>

</html>
