<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}
?>

<?php

// Inicializar a variável para armazenar a consulta
$sql = "SELECT c.*, p.nome_propriedade, i.nome_cliente FROM contratos c 
JOIN propriedade p ON c.id_propriedade = p.idpropriedade 
JOIN cliente i ON c.id_cliente = i.idcliente";


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
                    <option value="arrendamento">Arrendamento</option>
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
                <?php if (count($contratos) > 0): ?>
                    <?php foreach ($contratos as $contrato): ?>
                        <tr>
                            <td><?php echo $contrato['id_contrato']; ?></td>
                            <td><?php echo ucfirst($contrato['tipo_contrato']); ?></td>
                            <td><?php echo $contrato['nome_propriedade']; ?></td>
                            <td><?php echo $contrato['nome_cliente']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($contrato['data_inicio_residencia'])); ?></td>
                            <td><?php echo ($contrato['data_final_residencia'] != null) ? date('d/m/Y', strtotime($contrato['data_final_residencia'])) : 'N/A'; ?></td>
                            <td><?php echo number_format($contrato['valor_aluguel'], 2, ',', '.'); ?></td>
                            <td><a href="detalhes_contrato.php?id=<?php echo $contrato['id_contrato']; ?>">Ver Detalhes</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Nenhum contrato encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>

    <script src="../scripts/script_contratos.js"></script>
</body>
</html>
