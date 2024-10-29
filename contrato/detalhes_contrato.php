<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id_contrato = intval($_GET['id']); // Converte para inteiro para evitar SQL Injection

    // Prepara a consulta SQL
    $sql = "SELECT 
            contratos.*,
            propriedade.nome_propriedade,
            cliente.nome_cliente
            FROM contratos
            JOIN propriedade ON contratos.id_propriedade = propriedade.idpropriedade
            JOIN cliente ON contratos.id_cliente = cliente.idcliente
            WHERE contratos.id_contratos = $id_contrato";

    $result = $conn->query($sql);

    // Verifica se a contrato foi encontrada
    if ($result->num_rows > 0) {
        $contrato = $result->fetch_assoc();
    } else {
        echo "Contrato não encontrado.";
        exit;
    }
} else {
    echo "ID do contrato não fornecido.";
    exit; // Encerra o script se o ID não for fornecido
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Contrato</title>
    <link rel="stylesheet" href="../style/style_detalhes.css">
</head>

<body>
    <header>
        <h1>Detalhes do Contrato</h1>
    </header>

    <section class="detalhes-contrato">
        <h2>Resumo do Contrato</h2>

        <div class="contrato-info">
            <p><strong>ID do Contrato:</strong> <?php echo $contrato['id_contratos']; ?></p>
            <p><strong>Tipo de Contrato:</strong> <?php echo $contrato['tipo_contrato']; ?></p>
            <p><strong>Propriedade:</strong> <?php echo $contrato['nome_propriedade']; ?></p>
            <p><strong>Cliente:</strong> <?php echo $contrato['nome_cliente']; ?></p>
            <p><strong>Valor (R$):</strong> <?php echo $contrato['valor_aluguel']; ?></p>
            <p><strong>Data de Vencimento:</strong> <?php echo date('d/m/Y', strtotime($contrato['vencimento'])); ?></p>
            <p><strong>Data de Início:</strong> <?php echo date('d/m/Y', strtotime($contrato['data_inicio_residencia'])); ?></p>
            <p><strong>Data de Término:</strong> <?php echo date('d/m/Y', strtotime($contrato['data_final_residencia'])); ?></p>
            <p><strong>Período de Residência:</strong> <?php echo $contrato['periodo_residencia']; ?> dias</p>
        </div>

        <div class="acoes">
            <a href="listar_contratos.php">Voltar</a>
            <a href="editar_contrato.php?id=<?php echo $contrato['id_contratos']; ?>">Editar Contrato</a>

            <?php if ($contrato['tipo_contrato'] == 'ARRENDAMENTO'): ?>
                <a href="abrir_contrato_arrendamento.php?id=<?php echo $contrato['id_contratos']; ?>">Abrir Contrato</a>
            <?php elseif ($contrato['tipo_contrato'] == 'VENDA'): ?>
                <a href="abrir_contrato_venda.php?id=<?php echo $contrato['id_contratos']; ?>">Abrir Contrato</a>
            <?php else: ?>
                <a href="abrir_contrato_aluguel.php?id=<?php echo $contrato['id_contratos']; ?>">Abrir Contrato</a>
            <?php endif; ?>

            <!-- Formulário para Deletar Contrato -->
            <form method="POST" action="deletar_contrato.php" style="display:inline;">
                <input type="hidden" name="id_contrato" value="<?php echo $contrato['id_contratos']; ?>">
                <button type="submit" class="form_deletar">
                    Deletar Contrato
                </button>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de contratos</p>
    </footer>
</body>

</html>
