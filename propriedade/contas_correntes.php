<?php
require_once "../conexao/conexao.php"; // Sua conexão com o banco de dados
$id_propriedade = $_GET['id_propriedade'] ?? 1;

// Busca o nome da propriedade
$sql_nome_propriedade = "
    SELECT nome_propriedade 
    FROM propriedade 
    WHERE idpropriedade = $id_propriedade
";
$dados_nome = mysqli_query($conn, $sql_nome_propriedade);
$nome_propriedade = mysqli_fetch_assoc($dados_nome)['nome_propriedade'] ?? 'Propriedade Desconhecida';


// Busca os movimentos financeiros da propriedade
$sql_movimentos = "SELECT * FROM conta_corrente_propriedade WHERE id_propriedade = $id_propriedade ORDER BY data_movimento DESC";
$dados_movimentos = mysqli_query($conn, $sql_movimentos);

$movimentos = [];
while ($linha = mysqli_fetch_assoc($dados_movimentos)) {
    $movimentos[] = $linha;
}

// Busca o saldo acumulado
$sql_saldo = "SELECT saldo_acumulado FROM conta_corrente_propriedade WHERE id_propriedade = $id_propriedade ORDER BY data_movimento DESC LIMIT 1";
$dados_saldo = mysqli_query($conn, $sql_saldo);
$saldo_acumulado = mysqli_fetch_assoc($dados_saldo)['saldo_acumulado'] ?? 0;
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
        <h2>Nome: <?php echo $nome_propriedade; ?></h2>
    </header>

    <section class="movimentos-section">
        <h3>Movimentações Financeiras</h3>
        <h3>Saldo Atual: R$ <?php echo number_format($saldo_acumulado, 2, ',', '.'); ?></h3>
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
        <a href="movimento_conta.php">Adicionar um movimento</a>
    </section>
</body>

</html>
