<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}
?>

<?php
$id_propriedade = $_GET['id_propriedade'] ?? 1;

// Busca o nome da propriedade e o valor adquirido
$sql_propriedade = "SELECT nome_propriedade, valor_adquirido
                    FROM propriedade 
                    WHERE idpropriedade = $id_propriedade";

$dados_prop = mysqli_query($conn, $sql_propriedade);
$propriedade = mysqli_fetch_assoc($dados_prop);

// Verifica se a propriedade foi encontrada
$nome_propriedade = $propriedade['nome_propriedade'] ?? 'Propriedade Desconhecida';
$valor_adquirido = $propriedade['valor_adquirido'] ?? 'Valor Desconhecido';

// Busca os movimentos financeiros da propriedade
$sql_movimentos = "SELECT * FROM conta_corrente_propriedade WHERE id_propriedade = $id_propriedade ORDER BY data_movimento DESC";
$dados_movimentos = mysqli_query($conn, $sql_movimentos);

$movimentos = [];
while ($linha = mysqli_fetch_assoc($dados_movimentos)) {
    $movimentos[] = $linha;
}

// Busca o saldo_acumulado anterior da propriedade em questão
$sql_saldo_acumulado = "SELECT saldo_acumulado FROM conta_corrente_propriedade WHERE id_propriedade = $id_propriedade ORDER BY id_movimento DESC LIMIT 1";
$dados_saldo = mysqli_query($conn, $sql_saldo_acumulado);
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
        <h3>Valor Adquirido: R$ <?php echo number_format($valor_adquirido, 2, ',', '.');?></h3>
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
                            <td><?php echo DateTime::createFromFormat('Y-m-d', $movimento['data_movimento'])->format('d/m/Y'); ?></td>
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
        <a href="movimento_conta.php?id_propriedade=<?php echo $id_propriedade; ?>">Adicionar um movimento</a>
        <a href="listar_propriedades.php">Voltar </a>


    </section>
</body>

</html>