<?php
require_once "../conexao/conexao.php";

// Verifica se o ID do Iquilino foi passado na URL
if (isset($_GET['id'])) {
    $id_inquilino = intval($_GET['id']); // Converte para inteiro para evitar SQL Injection

    // Prepara a consulta SQL
    $sql = "SELECT i.*, l.nome_cidade 
    FROM inquilino i 
    JOIN localizacao l ON id_localizacao = idlocalizacao
    WHERE idinquilino = $id_inquilino";


    $result = $conn->query($sql);

    // Verifica se a propriedade foi encontrada
    if ($result->num_rows > 0) {
        $inquilino = $result->fetch_assoc();
    } else {
        echo "Propriedade não encontrada.";
        exit; // Encerra o script se o inquilino não for encontrado
    }
} else {
    echo "ID do inquilino não fornecido.";
    exit; // Encerra o script se o ID não for fornecido
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
                <strong>ID do Inquilino:</strong>
                <span><?php echo $inquilino['idinquilino']; ?></span>
            </div>
            <div class="info-item">
                <strong>Nome:</strong>
                <span><?php echo $inquilino['nome_inquilino']; ?></span>
            </div>
            <div class="info-item">
                <strong>RG:</strong>
                <span><?php echo $inquilino['rg_numero']; ?></span>
            </div>
            <div class="info-item">
                <strong>CPF:</strong>
                <span><?php echo $inquilino['cpf_numero']; ?></span>
            </div>
            <div class="info-item">
                <strong>Endereço:</strong>
                <span><?php echo $inquilino['endereco']; ?></span>
            </div>
            <div class="info-item">
                <strong>Cidade:</strong>
                <span><?php echo $inquilino['nome_cidade']; ?></span>
            </div>
            <div class="info-item">
                <strong>Data de Nascimento:</strong>
                <span><?php echo date('d/m/Y', strtotime($inquilino['data_nascimento'])); ?> </span>
            </div>
            <div class="info-item">
                <strong>Telefone:</strong>
                <span><?php echo $inquilino['telefone']; ?></span>
            </div>
        </div>

        <h2>Documentos Associados</h2>
        <div class="documentos-info">
            <?php
            // Obtém os documentos associados à propriedade
            $sql_document = "SELECT * FROM documentacao_inquilino WHERE id_inquilino = $id_inquilino";
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
                                <?php echo htmlspecialchars($documento['nome_doc']); ?>
                            </a>
                            - Enviado em: <?php echo date('d/m/Y', strtotime($documento['data_upload'])); ?>
                            <a href="deletar_documento.php?id=<?php echo $documento['iddocumentacao_inquilino']; ?>&id_inquilino=<?php echo $inquilino['idinquilino']; ?>" onclick="return confirmarDeletar();">Deletar</a>
                        </li>
                    <?php endforeach; ?>
                    <a href="add_documento_inq_existente.php?idinquilino=<?php echo $inquilino['idinquilino']?>">Adicionar Documento (PDF)</a>
                    </ul>
            <?php else: ?>
                <p>Nenhum documento encontrado para este inquilino.</p>
                <p>Para vincular um documento à inquilino clique <a href="add_documento_inq_existente.php?idinquilino=<?php echo $inquilino['idinquilino']?>">aqui (PDF)</a>
            <?php endif; ?>


        </div>

        <div class="acoes">
            <a href="listar_inquilinos.php">Voltar</a>
            <a href="editar_inquilino.php?id=<?php echo $inquilino['idinquilino']; ?>">Editar Inquilino</a>
            <a id="deletar" href="deletar_inquilino.php?id=<?php echo $inquilino['idinquilino']; ?>" onclick="return confirmarDeletar();">Deletar Inquilino</a>
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