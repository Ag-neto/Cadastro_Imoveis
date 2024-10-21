<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Propriedades</title>
    <link rel="stylesheet" href="../style/listar_propriedade.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <script>
        // Função para mostrar ou esconder os campos de seleção baseados nos checkboxes marcados
        function toggleSelectField(checkbox, selectId) {
            var selectField = document.getElementById(selectId);
            if (checkbox.checked) {
                selectField.style.display = 'block';
            } else {
                selectField.style.display = 'none';
            }
        }
    </script>
</head>

<body>
    <header>
        <h1>Lista de Propriedades</h1>
    </header>

    <section class="form-section">
        <h2>Buscar Propriedade</h2>
        <form id="buscar-propriedade-form" method="GET" action="listar_propriedades.php">
            <div class="filtro-container">
                <div class="filtro-item">
                    <label for="nome">Buscar</label>
                    <input type="text" name="nome" id="nome" placeholder="Insira o nome">
                </div>
                <div class="filtro-item">
                    <input type="checkbox" name="cidade_checkbox" id="cidade_checkbox" onclick="toggleSelectField(this, 'select-cidade')">
                    <label for="cidade_checkbox">Cidade</label>
                    <select id="select-cidade" name="cidade" style="display:none;">
                        <option value="">Selecione uma cidade</option>
                        <?php
                        // Busca todas as cidades disponíveis no banco de dados
                        require_once "../conexao/conexao.php";
                        $resultCidades = $conn->query("SELECT DISTINCT nome_cidade FROM localizacao");
                        while ($row = $resultCidades->fetch_assoc()) {
                            echo '<option value="' . $row['nome_cidade'] . '">' . $row['nome_cidade'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="filtro-item">
                    <input type="checkbox" name="situacao_checkbox" id="situacao_checkbox" onclick="toggleSelectField(this, 'select-situacao')">
                    <label for="situacao_checkbox">Situação</label>
                    <select id="select-situacao" name="situacao" style="display:none;">
                        <option value="">Selecione uma situação</option>
                        <?php
                        // Busca todas as situações disponíveis no banco de dados
                        $resultSituacoes = $conn->query("SELECT DISTINCT nome_situacao FROM situacao");
                        while ($row = $resultSituacoes->fetch_assoc()) {
                            echo '<option value="' . $row['nome_situacao'] . '">' . $row['nome_situacao'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="filtro-item">
                    <input type="checkbox" name="tipo_propriedade_checkbox" id="tipo_propriedade_checkbox" onclick="toggleSelectField(this, 'select-tipo-propriedade')">
                    <label for="tipo_propriedade_checkbox">Tipo de Propriedade</label>
                    <select id="select-tipo-propriedade" name="tipo_propriedade" style="display:none;">
                        <option value="">Selecione um tipo de propriedade</option>
                        <?php
                        // Busca todos os tipos de propriedades disponíveis no banco de dados
                        $resultTipos = $conn->query("SELECT DISTINCT nome_tipo FROM tipo_prop");
                        while ($row = $resultTipos->fetch_assoc()) {
                            echo '<option value="' . $row['nome_tipo'] . '">' . $row['nome_tipo'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
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
                    <th>Detalhes</th>
                    <th><i class="bi bi-bank"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once "../conexao/conexao.php";

                // Inicializa o array de condições
                $condicoes = [];

                // Verifica se os filtros foram aplicados
                if (!empty($_GET['nome'])) {
                    $nome = $conn->real_escape_string($_GET['nome']);
                    $condicoes[] = "p.nome_propriedade LIKE '%$nome%'";
                }
                if (!empty($_GET['cidade'])) {
                    $cidade = $conn->real_escape_string($_GET['cidade']);
                    $condicoes[] = "l.nome_cidade = '$cidade'";
                }
                if (!empty($_GET['situacao'])) {
                    $situacao = $conn->real_escape_string($_GET['situacao']);
                    $condicoes[] = "s.nome_situacao = '$situacao'";
                }
                if (!empty($_GET['tipo_propriedade'])) {
                    $tipoPropriedade = $conn->real_escape_string($_GET['tipo_propriedade']);
                    $condicoes[] = "t.nome_tipo = '$tipoPropriedade'";
                }

                // Prepara a consulta SQL
                $sql = "SELECT p.*, t.nome_tipo, l.nome_cidade, s.nome_situacao, e.sigla 
                FROM propriedade p 
                JOIN tipo_prop t ON p.id_tipo_prop = t.id_tipo_prop
                JOIN localizacao l ON p.id_localizacao = l.idlocalizacao
                JOIN estados e ON l.id_estado = e.id_estado
                JOIN situacao s ON p.id_situacao = s.id_situacao";

                // Adiciona as condições de busca, se houver
                if (!empty($condicoes)) {
                    $sql .= " WHERE " . implode(" AND ", $condicoes);
                }

                // Executa a consulta
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Loop para listar as propriedades
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['idpropriedade'] . '</td>';
                        echo '<td>' . $row['nome_propriedade'] . '</td>';
                        echo '<td>' . $row['nome_tipo'] . '</td>';
                        echo '<td>' . $row['nome_cidade'] . " - " . $row['sigla'] . '</td>';
                        echo '<td>' . number_format($row['valor_adquirido'], 2, ',', '.') . '</td>';
                        echo '<td>' . $row['nome_situacao'] . '</td>';
                        echo '<td><a href="detalhes_propriedade.php?id=' . $row['idpropriedade'] . '">Ver Detalhes</a></td>';
                        echo '<td><a href="contas_correntes.php"><i class="bi bi-bank"></i></a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="7">Nenhuma propriedade encontrada.</td></tr>';
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