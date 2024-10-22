<?php
require_once "../conexao/conexao.php";

// Inicializar a variável para armazenar a consulta
$sql = "SELECT c.*, p.nome_propriedade, i.nome_inquilino FROM contratos c 
JOIN propriedade p ON c.id_propriedade = p.idpropriedade 
JOIN inquilino i ON c.id_inquilino = i.idinquilino";


// Verifica se há uma busca
if (isset($_GET['busca']) && $_GET['busca'] != '') {
    $busca = mysqli_real_escape_string($conn, $_GET['busca']);
    $sql .= " WHERE nome_cliente LIKE '%$busca%' OR nome_propriedade LIKE '%$busca%'";
}

// Verifica se há um filtro de tipo
if (isset($_GET['tipo']) && $_GET['tipo'] != '') {
    $tipo = mysqli_real_escape_string($conn, $_GET['tipo']);
    $sql .= " AND tipo_contrato = '$tipo'";
}

// Executar a consulta
$result = mysqli_query($conn, $sql);

// Verifica se a consulta retornou resultados
$contratos = [];
if ($result) {
    while ($linha = mysqli_fetch_assoc($result)) {
        $contratos[] = $linha;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Contratos</title>
    <link rel="stylesheet" href="../style/listar_contratos.css">
</head>
<body>
    <header>
        <h1>Lista de Contratos</h1>
    </header>

    <section class="form-section">
        <h2>Buscar Contrato</h2>
        <form id="buscar-contrato-form" method="GET" action="listar_contratos.php">
            <div class="form-group">
                <label for="busca">Buscar por nome do cliente ou propriedade:</label>
                <input type="text" id="busca" name="busca" placeholder="Digite o nome do cliente ou da propriedade">
            </div>
            <div class="form-group">
                <label for="tipo">Filtrar por tipo de contrato:</label>
                <select id="tipo" name="tipo">
                    <option value="">Todos</option>
                    <option value="venda">Venda</option>
                    <option value="aluguel">Aluguel</option>
                    <option value="arrendamento">Arrendamento</option> <!-- Adicionado arrendamento -->
                </select>
            </div>
            <button type="submit">Buscar</button>
            <a href="../index.php" class="btn-voltar">Voltar</a>
            <a href="tipo_contrato.php" class="btn-criar_contrato">Gerar Contrato</a>
        </form>
    </section>

    <section class="contratos-lista">
        <h2>Contratos Registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Contrato</th>
                    <th>Propriedade</th>
                    <th>Cliente</th>
                    <th>Data Início</th>
                    <th>Data Fim</th>
                    <th>Valor (R$)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Exemplo de dados estáticos -->
                <tr>
                    <td>1</td>
                    <td>Venda</td>
                    <td>Apartamento Central</td>
                    <td>João da Silva</td>
                    <td>01/01/2024</td>
                    <td>N/A</td>
                    <td>450.000,00</td>
                    <td><a href="detalhes_contrato.php?id=1">Ver Detalhes</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Aluguel</td>
                    <td>Casa Verde</td>
                    <td>Maria Oliveira</td>
                    <td>01/05/2024</td>
                    <td>01/05/2025</td>
                    <td>1.200,00</td>
                    <td><a href="detalhes_contrato.php?id=2">Ver Detalhes</a></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Arrendamento</td>
                    <td>Sítio do Campo</td>
                    <td>Roberto Santos</td>
                    <td>15/06/2024</td>
                    <td>15/06/2025</td>
                    <td>2.500,00</td>
                    <td><a href="detalhes_contrato.php?id=3">Ver Detalhes</a></td>
                </tr>
                <!-- Aqui vamos fazer um loop para listar os contratos dinâmicos -->
            </tbody>
        </table>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>

    <script src="../scripts/script_contratos.js"></script>
</body>
</html>
