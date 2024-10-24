<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}
?>

<?php 

// Verifica se o ID do cliente foi passado na URL
if (isset($_GET['id'])) {
    $id_cliente = intval($_GET['id']); // Converte para inteiro para evitar SQL Injection

    // Prepara a consulta SQL usando prepared statements
    $sql = "SELECT i.*, l.nome_cidade 
            FROM cliente i 
            JOIN localizacao l ON i.id_localizacao = l.idlocalizacao
            WHERE i.idcliente = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o cliente foi encontrado
    if ($result->num_rows > 0) {
        $cliente = $result->fetch_assoc();
    } else {
        echo "cliente não encontrado.";
        exit;
    }
} else {
    echo "ID do cliente não fornecido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do cliente</title>
    <link rel="stylesheet" href="../style/style_detalhes_cliente.css">
</head>

<body>
    <header>
        <h1>Detalhes do cliente</h1>
    </header>

    <section class="detalhes-propriedade">
        <h2>Resumo do cliente</h2>
        <div class="propriedade-info">
            <div class="info-item">
                <strong>ID do cliente:</strong> <span><?= $cliente['idcliente']; ?></span>
            </div>
            <div class="info-item">
                <strong>Nome:</strong> <span><?= htmlspecialchars($cliente['nome_cliente']); ?></span>
            </div>
            <div class="info-item">
                <strong>RG:</strong> <span><?= htmlspecialchars($cliente['rg_numero']); ?></span>
            </div>
            <div class="info-item">
                <strong>CPF:</strong> <span><?= htmlspecialchars($cliente['cpf_numero']); ?></span>
            </div>
            <div class="info-item">
                <strong>Endereço:</strong> <span><?= htmlspecialchars($cliente['endereco']); ?></span>
            </div>
            <div class="info-item">
                <strong>Cidade:</strong> <span><?= htmlspecialchars($cliente['nome_cidade']); ?></span>
            </div>
            <div class="info-item">
                <strong>Data de Nascimento:</strong> 
                <span><?= date('d/m/Y', strtotime($cliente['data_nascimento'])); ?></span>
            </div>
            <div class="info-item">
                <strong>Telefone:</strong> <span><?= htmlspecialchars($cliente['telefone']); ?></span>
            </div>
            <div class="info-item">
                <strong>Profissão:</strong> <span><?= htmlspecialchars($cliente['profissao']); ?></span>
            </div>
            <div class="info-item">
                <strong>Nacionalidade:</strong> <span><?= htmlspecialchars($cliente['nacionalidade']); ?></span>
            </div>
            <div class="info-item">
                <strong>CEP:</strong> <span><?= htmlspecialchars($cliente['cep']); ?></span>
            </div>
        </div>

        <h2>Documentos Associados</h2>
        <div class="documentos-info">
            <?php
            // Consulta para obter os documentos associados ao cliente
            $sql_document = "SELECT * FROM documentacao_cliente WHERE id_cliente = ?";
            $stmt_doc = $conn->prepare($sql_document);
            $stmt_doc->bind_param("i", $id_cliente);
            $stmt_doc->execute();
            $result_docs = $stmt_doc->get_result();

            if ($result_docs->num_rows > 0): ?>
                <ul>
                    <?php while ($documento = $result_docs->fetch_assoc()): ?>
                        <li>
                            <a href="<?= htmlspecialchars($documento['path']); ?>" target="_blank">
                                <?= htmlspecialchars($documento['nome_doc']); ?>
                            </a> - Enviado em: <?= date('d/m/Y', strtotime($documento['data_upload'])); ?>
                            <a href="deletar_documento.php?id=<?= $documento['iddocumentacao_cliente']; ?>&id_cliente=<?= $id_cliente; ?>" 
                               onclick="return confirmarDeletar();">Deletar</a>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <a href="add_documento_cli_existente.php?idcliente=<?= $id_cliente; ?>">Adicionar Documento (PDF)</a>
            <?php else: ?>
                <p>Nenhum documento encontrado para este cliente.</p>
                <p>
                    Para vincular um documento, clique 
                    <a href="add_documento_cli_existente.php?idcliente=<?= $id_cliente; ?>">aqui (PDF)</a>
                </p>
            <?php endif; ?>
        </div>

        <div class="acoes">
        <button onclick="history.back()">Voltar</button>
            <a href="editar_cliente.php?id=<?= $id_cliente; ?>">Editar cliente</a>
            <a id="deletar" href="deletar_cliente.php?id=<?= $id_cliente; ?>" 
               onclick="return confirmarDeletar();">Deletar cliente</a>
        </div>

        <script>
            function confirmarDeletar() {
                return confirm("Você tem certeza que deseja deletar este cliente? Esta ação não poderá ser desfeita.");
            }
        </script>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>
</body>

</html>
