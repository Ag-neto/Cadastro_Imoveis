<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}
?>

<?php

// Verifica se o ID da propriedade foi passado na URL
if (isset($_GET['id'])) {
    $id_propriedade = intval($_GET['id']); // Converte para inteiro para evitar SQL Injection

    // Prepara a consulta SQL
    $sql = "SELECT p.*, t.nome_tipo, l.nome_cidade, s.nome_situacao, e.sigla 
    FROM propriedade p 
    JOIN tipo_prop t ON p.id_tipo_prop = t.id_tipo_prop
    JOIN localizacao l ON p.id_localizacao = l.idlocalizacao
    JOIN situacao s ON p.id_situacao = s.id_situacao
    JOIN estados e ON l.id_estado = e.id_estado
    WHERE p.idpropriedade = $id_propriedade";


    $result = $conn->query($sql);

    // Verifica se a propriedade foi encontrada
    if ($result->num_rows > 0) {
        $propriedade = $result->fetch_assoc();
    } else {
        echo "Propriedade não encontrada.";
        exit; // Encerra o script se a propriedade não for encontrada
    }
} else {
    echo "ID da propriedade não fornecido.";
    exit; // Encerra o script se o ID não for fornecido
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Propriedade</title>
    <link rel="stylesheet" href="../style/style_detalhes_propriedade.css">
</head>

<body>
    <header>
        <h1>Detalhes da Propriedade</h1>
    </header>

    <section class="detalhes-propriedade">
        <h2>Resumo da Propriedade</h2>

        <div class="propriedade-info">
            <div class="info-item">
                <strong>ID da Propriedade:</strong>
                <span><?php echo $propriedade['idpropriedade']; ?></span>
            </div>
            <div class="info-item">
                <strong>Nome:</strong>
                <span><?php echo $propriedade['nome_propriedade']; ?></span>
            </div>
            <div class="info-item">
                <strong>Nome Fantasia:</strong>
                <span><?php echo $propriedade['nome_fantasia']; ?></span>
            </div>
            <div class="info-item">
                <strong>Tipo:</strong>
                <span><?php echo $propriedade['nome_tipo']; ?></span>
            </div>
            <div class="info-item">
                <strong>Cidade:</strong>
                <span><?php echo $propriedade['nome_cidade'] . " - " . $propriedade['sigla']; ?></span>
            </div>
            <div class="info-item">
                <strong>Endereço:</strong>
                <span><?php echo $propriedade['endereco']; ?></span>
            </div>
            <div class="info-item">
                <strong>Tamanho:</strong>
                <span><?php echo $propriedade['tamanho']; ?> m²</span>
            </div>
            <div class="info-item">
                <strong>Valor Adquirido:</strong>
                <span>R$ <?php echo number_format($propriedade['valor_adquirido'], 2, ',', '.'); ?></span>
            </div>
            <div class="info-item">
                <strong>Situação:</strong>
                <span><?php echo $propriedade['nome_situacao']; ?></span>
            </div>
            <div class="info-item">
                <strong>Data de Registro:</strong>
                <span><?php echo date('d/m/Y', strtotime($propriedade['data_registro'])); ?></span>
            </div>
            <div class="info-item">
                <strong>Tipo de Imposto:</strong>
                <span><?php echo $propriedade['tipo_imposto']; ?></span>
            </div>
            <div class="info-item">
                <strong>Valor do Imposto:</strong>
                <span>R$ <?php echo number_format($propriedade['valor_imposto'], 2, ',', '.'); ?></span>
            </div>
            <div class="info-item">
                <strong>Periodicidade do Imposto:</strong>
                <span><?php echo $propriedade['periodo_imposto']; ?></span>
            </div>
            <div class="info-item">
                <strong>N° INCRA:</strong>
                <span><?php echo $propriedade['incra']; ?></span>
            </div>
            
        </div>

        <h2>Documentos Associados</h2>
        <div class="documentos-info">
            <?php
            // Obtém os documentos associados à propriedade
            $sql_document = "SELECT * FROM documentacao_propriedade WHERE id_propriedade = $id_propriedade";
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
                            <a href="deletar_documento.php?id=<?php echo $documento['iddocumentacao_propriedade']; ?>&id_propriedade=<?php echo $propriedade['idpropriedade']; ?>" onclick="return confirmarDeletar();">Deletar</a>
                        </li>
                    <?php endforeach; ?>
                    <a href="add_documento_prop_existente.php?idpropriedade=<?php echo $propriedade['idpropriedade']?>">Adicionar Documento (PDF)</a>
                    </ul>
            <?php else: ?>
                <p>Nenhum documento encontrado para esta propriedade.</p>
                <p>Para vincular um documento à propriedade clique <a href="add_documento_prop_existente.php?idpropriedade=<?php echo $propriedade['idpropriedade']?>">Aqui (PDF)</a>
            <?php endif; ?>


        </div>

        <div class="acoes">
            <a href="listar_propriedades.php">Voltar</a>
            <a href="../index.php">Menu Principal</a>
            <a href="editar_propriedade.php?id=<?php echo $propriedade['idpropriedade']; ?>">Editar Propriedade</a>
            <a id="deletar" href="deletar_propriedade.php?id=<?php echo $propriedade['idpropriedade']; ?>" onclick="return confirmarDeletar();">Deletar Propriedade</a>
        </div>

        <script>
            function confirmarDeletar() {
                return confirm("Você tem certeza que deseja deletar esta propriedade? Esta ação não pode ser desfeita.");
            }
        </script>


    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>
</body>

</html>