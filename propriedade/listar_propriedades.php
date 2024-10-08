<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Propriedades</title>
    <link rel="stylesheet" href="../style/listar_propriedade.css">
</head>

<body>
    <header>
        <h1>Lista de Propriedades</h1>
    </header>

    <section class="form-section">
        <h2>Buscar Propriedade</h2>
        <form id="buscar-propriedade-form" method="GET" action="listar_propriedades.php">
            <div class="form-group">
                <label for="busca">Buscar por nome da propriedade ou cidade:</label>
                <input type="text" id="busca" name="busca" placeholder="Digite o nome da propriedade ou cidade">
            </div>

            <button type="submit">Buscar</button>
            <a href="../index.php" class="btn-voltar">Voltar</a>
            <a href="cadastro_propriedade.php" class="btn-criar_propriedade">Cadastrar Propriedade</a>
        </form>
    </section>

    <section class="propriedades-lista">
        <h2>Propriedades Cadastradas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Cidade</th>
                    <th>Valor (R$)</th>
                    <th>Situação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once "../conexao/conexao.php";

                // Verifica se há uma busca
                $busca = isset($_GET['busca']) ? $_GET['busca'] : '';
                $busca = $conn->real_escape_string($busca); // Evita SQL Injection

                // Prepara a consulta SQL
                $sql = "SELECT p.*, t.nome_tipo, l.nome_cidade, s.nome_situacao 
                        FROM propriedade p 
                        JOIN tipo_prop t ON p.id_tipo_prop = t.id_tipo_prop
                        JOIN localizacao l ON p.id_localizacao = l.idlocalizacao
                        JOIN situacao s ON p.id_situacao = s.id_situacao";

                // Adiciona condição de busca se houver
                if (!empty($busca)) {
                    $sql .= " WHERE p.nome_propriedade LIKE '%$busca%' 
                               OR l.nome_cidade LIKE '%$busca%'";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Loop para listar as propriedades
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['idpropriedade'] . '</td>'; // Supondo que o ID da propriedade seja 'id_propriedade'
                        echo '<td>' . $row['nome_propriedade'] . '</td>';
                        echo '<td>' . $row['nome_tipo'] . '</td>';
                        echo '<td>' . $row['nome_cidade'] . '</td>';
                        echo '<td>' . number_format($row['valor_adquirido'], 2, ',', '.') . '</td>'; // Formata o valor
                        echo '<td>' . $row['nome_situacao'] . '</td>';
                        echo '<td><a href="detalhes_propriedade.php?id=' . $row['idpropriedade'] . '">Ver Detalhes</a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">Nenhuma propriedade encontrada.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>

    <script src="../scripts/script_propriedades.js"></script>
</body>

</html>
