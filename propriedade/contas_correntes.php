<?php
require_once "../conexao/conexao.php"; // Sua conexão com o banco de dados

// Supondo que o ID da propriedade seja passado pela URL
$id_propriedade = $_GET['id_propriedade'] ?? 1;

// Busca os movimentos financeiros da propriedade
$query = "SELECT * FROM conta_corrente_propriedade WHERE id_propriedade = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id_propriedade]);
$movimentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Busca o saldo acumulado
$query_saldo = "SELECT saldo_acumulado FROM conta_corrente_propriedade WHERE id_propriedade = ? ORDER BY data_movimento DESC LIMIT 1";
$stmt_saldo = $pdo->prepare($query_saldo);
$stmt_saldo->execute([$id_propriedade]);
$saldo_acumulado = $stmt_saldo->fetchColumn() ?? 0;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conta Corrente da Propriedade</title>
    <link rel="stylesheet" href="../style/style_conta_corrente.css">
</head>

<body>
    <header>
        <h1>Conta Corrente da Propriedade</h1>
        <h2>ID da Propriedade: <?php echo $id_propriedade; ?></h2>
    </header>

    <section class="movimentos-section">
        <h3>Movimentações Financeiras</h3>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Tipo</th>
                    <th>Valor (R$)</th>
                    <th>Saldo Acumulado (R$)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($movimentos) > 0): ?>
                    <?php foreach ($movimentos as $movimento): ?>
                        <tr>
                            <td><?php echo $movimento['data_movimento']; ?></td>
                            <td><?php echo $movimento['descricao']; ?></td>
                            <td><?php echo ucfirst($movimento['tipo_movimento']); ?></td>
                            <td><?php echo number_format($movimento['valor'], 2, ',', '.'); ?></td>
                            <td><?php echo number_format($movimento['saldo_acumulado'], 2, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Nenhum movimento financeiro encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <h3>Saldo Atual: R$ <?php echo number_format($saldo_acumulado, 2, ',', '.'); ?></h3>
    </section>

    <section class="form-section">
        <h3>Adicionar Movimento Financeiro</h3>
        <form method="POST" action="add_movimento.php">
            <input type="hidden" name="id_propriedade" value="<?php echo $id_propriedade; ?>">
            <label for="descricao">Descrição:</label>
            <input type="text" id="descricao" name="descricao" required>

            <label for="valor">Valor (R$):</label>
            <input type="number" id="valor" name="valor" step="0.01" required>

            <label for="tipo_movimento">Tipo de Movimento:</label>
            <select id="tipo_movimento" name="tipo_movimento" required>
                <option value="receita">Receita</option>
                <option value="despesa">Despesa</option>
            </select>

            <button type="submit">Adicionar Movimento</button>
        </form>
    </section>

</body>

</html>
