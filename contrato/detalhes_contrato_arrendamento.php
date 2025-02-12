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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
            <p><strong>Valor (R$):</strong> <?php echo $contrato['valor']; ?></p>
            <p><strong>Data de Vencimento:</strong> <?php echo date('d/m/Y', strtotime($contrato['vencimento'])); ?></p>
            <p><strong>Data de Início:</strong> <?php echo date('d/m/Y', strtotime($contrato['data_inicio_residencia'])); ?></p>
            <p><strong>Data de Término:</strong> <?php echo date('d/m/Y', strtotime($contrato['data_final_residencia'])); ?></p>
            <p><strong>Período de Residência:</strong> <?php echo $contrato['periodo_residencia']; ?> dias</p>
        </div>

        <h2>Contrato Anexado</h2>
        <div class="documentos-info">
            <?php

            $idDoContrato = $contrato['id_contratos'];

            // Obtém os documentos associados à propriedade
            $sql_document = "SELECT * FROM documentacao_contrato WHERE id_contrato = $idDoContrato";
            $dados_document = mysqli_query($conn, $sql_document);

            // Armazena todos os documentos em um array
            $documentos = [];
            while ($documento = mysqli_fetch_assoc($dados_document)) {
                $documentos[] = $documento; // Armazena cada documento no array
            }

            // Contar documentos
            $total_documentos = count($documentos);
            echo "Total de documentos encontrados: $total_documentos<br>";

            // Exibir documentos
            if ($total_documentos > 0): ?>
                <ul>
                    <?php foreach ($documentos as $documento): ?>
                        <li>
                            <a href="<?php echo $documento['path']; ?>" target="_blank">
                                <?php echo htmlspecialchars($documento['nome_doc']); ?><i class="bi bi-link-45deg"></i>
                            </a>
                            - Contrato anexado em: <?php echo date('d/m/Y', strtotime($documento['data_upload'])); ?>
                            <a href="deletar_documento.php?id=<?php echo $documento['iddocumentacao_contrato']; ?>&id_contrato=<?php echo $idDoContrato; ?>" onclick="return confirmarDeletar();">Deletar</a>
                        </li>
                    <?php endforeach; ?>
                    <a href="add_doc_arrendamento_existente.php?id_contrato=<?php echo $idDoContrato; ?>">Adicionar contrato (PDF)</a>
                    </ul>
            <?php else: ?>
                <p>Nenhum documento encontrado para este contrato.</p>
                <p>Para vincular um documento ao contrato clique <a href="add_doc_arrendamento_existente.php?id_contrato=<?php echo $idDoContrato; ?>">Aqui (PDF)<i class="bi bi-link-45deg"></i></a>
            <?php endif; ?>


        </div>

        <div class="acoes">
            <a href="listar_contratos.php">Voltar</a>
            <a href="editar_contrato_arrendamento.php?id=<?php echo $contrato['id_contratos']; ?>">Editar Contrato</a>

            <?php if ($contrato['tipo_contrato'] == 'ARRENDAMENTO'): ?>
                <!-- DISPONÍVEL EM PRÓXIMAS ATUALIZAÇÕES <a href="abrir_contrato_arrendamento.php?id=<?php //echo $contrato['id_contratos']; ?>">Abrir Contrato</a>-->
            <?php elseif ($contrato['tipo_contrato'] == 'VENDA'): ?>
                <a href="abrir_contrato_venda.php?id=<?php echo $contrato['id_contratos']; ?>">Abrir Contrato</a>
            <?php else: ?>
                <!--  DISPONÍVEL NA PRÓXIMA ATUALIZAÇÃO  <a href="abrir_contrato_arrendamento.php?id=<?php //echo $contrato['id_contratos']; ?>">Abrir Contrato</a>-->
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
