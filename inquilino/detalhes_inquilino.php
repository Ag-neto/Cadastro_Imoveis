<?php 
require_once "../conexao/conexao.php";

// Verifica se o ID do inquilino foi passado na URL
if (isset($_GET['id'])) {
    $id_inquilino = intval($_GET['id']); // Converte para inteiro para evitar SQL Injection

    // Prepara a consulta SQL usando prepared statements
    $sql = "SELECT i.*, l.nome_cidade 
            FROM inquilino i 
            JOIN localizacao l ON i.id_localizacao = l.idlocalizacao
            WHERE i.idinquilino = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_inquilino);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o inquilino foi encontrado
    if ($result->num_rows > 0) {
        $inquilino = $result->fetch_assoc();
    } else {
        echo "Inquilino não encontrado.";
        exit;
    }
} else {
    echo "ID do inquilino não fornecido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Inquilino</title>
    <link rel="stylesheet" href="../style/style_detalhes_inquilino.css">
</head>

<body>
    <header>
        <h1>Detalhes do Inquilino</h1>
    </header>

    <section class="detalhes-propriedade">
        <h2>Resumo do Inquilino</h2>
        <div class="propriedade-info">
            <div class="info-item">
                <strong>ID do Inquilino:</strong> <span><?= $inquilino['idinquilino']; ?></span>
            </div>
            <div class="info-item">
                <strong>Nome:</strong> <span><?= htmlspecialchars($inquilino['nome_inquilino']); ?></span>
            </div>
            <div class="info-item">
                <strong>RG:</strong> <span><?= htmlspecialchars($inquilino['rg_numero']); ?></span>
            </div>
            <div class="info-item">
                <strong>CPF:</strong> <span><?= htmlspecialchars($inquilino['cpf_numero']); ?></span>
            </div>
            <div class="info-item">
                <strong>Endereço:</strong> <span><?= htmlspecialchars($inquilino['endereco']); ?></span>
            </div>
            <div class="info-item">
                <strong>Cidade:</strong> <span><?= htmlspecialchars($inquilino['nome_cidade']); ?></span>
            </div>
            <div class="info-item">
                <strong>Data de Nascimento:</strong> 
                <span><?= date('d/m/Y', strtotime($inquilino['data_nascimento'])); ?></span>
            </div>
            <div class="info-item">
                <strong>Telefone:</strong> <span><?= htmlspecialchars($inquilino['telefone']); ?></span>
            </div>
            <div class="info-item">
                <strong>Profissão:</strong> <span><?= htmlspecialchars($inquilino['profissao']); ?></span>
            </div>
            <div class="info-item">
                <strong>Nacionalidade:</strong> <span><?= htmlspecialchars($inquilino['nacionalidade']); ?></span>
            </div>
            <div class="info-item">
                <strong>CEP:</strong> <span><?= htmlspecialchars($inquilino['cep']); ?></span>
            </div>
        </div>

        <h2>Documentos Associados</h2>
        <div class="documentos-info">
            <?php
            // Consulta para obter os documentos associados ao inquilino
            $sql_document = "SELECT * FROM documentacao_inquilino WHERE id_inquilino = ?";
            $stmt_doc = $conn->prepare($sql_document);
            $stmt_doc->bind_param("i", $id_inquilino);
            $stmt_doc->execute();
            $result_docs = $stmt_doc->get_result();

            if ($result_docs->num_rows > 0): ?>
                <ul>
                    <?php while ($documento = $result_docs->fetch_assoc()): ?>
                        <li>
                            <a href="<?= htmlspecialchars($documento['path']); ?>" target="_blank">
                                <?= htmlspecialchars($documento['nome_doc']); ?>
                            </a> - Enviado em: <?= date('d/m/Y', strtotime($documento['data_upload'])); ?>
                            <a href="deletar_documento.php?id=<?= $documento['iddocumentacao_inquilino']; ?>&id_inquilino=<?= $id_inquilino; ?>" 
                               onclick="return confirmarDeletar();">Deletar</a>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <a href="add_documento_inq_existente.php?idinquilino=<?= $id_inquilino; ?>">Adicionar Documento (PDF)</a>
            <?php else: ?>
                <p>Nenhum documento encontrado para este inquilino.</p>
                <p>
                    Para vincular um documento, clique 
                    <a href="add_documento_inq_existente.php?idinquilino=<?= $id_inquilino; ?>">aqui (PDF)</a>
                </p>
            <?php endif; ?>
        </div>

        <div class="acoes">
        <button onclick="history.back()">Voltar</button>
            <a href="editar_inquilino.php?id=<?= $id_inquilino; ?>">Editar Inquilino</a>
            <a id="deletar" href="deletar_inquilino.php?id=<?= $id_inquilino; ?>" 
               onclick="return confirmarDeletar();">Deletar Inquilino</a>
        </div>

        <script>
            function confirmarDeletar() {
                return confirm("Você tem certeza que deseja deletar este inquilino? Esta ação não poderá ser desfeita.");
            }
        </script>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>
</body>

</html>
