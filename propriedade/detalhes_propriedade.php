<?php
require_once "../conexao/conexao.php";

// Verifica se o ID da propriedade foi passado na URL
if (isset($_GET['id'])) {
    $id_propriedade = intval($_GET['id']); // Converte para inteiro para evitar SQL Injection

    // Prepara a consulta SQL
    $sql = "SELECT p.*, t.nome_tipo, l.nome_cidade, s.nome_situacao 
            FROM propriedade p 
            JOIN tipo_prop t ON p.id_tipo_prop = t.id_tipo_prop
            JOIN localizacao l ON p.id_localizacao = l.idlocalizacao
            JOIN situacao s ON p.id_situacao = s.id_situacao
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
                <strong>Tipo:</strong>
                <span><?php echo $propriedade['nome_tipo']; ?></span>
            </div>
            <div class="info-item">
                <strong>Cidade:</strong>
                <span><?php echo $propriedade['nome_cidade']; ?></span>
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
        </div>

        <div class="acoes">
            <button onclick="window.history.back();">Voltar</button>
            <button onclick="editarPropriedade(<?php echo $propriedade['idpropriedade']; ?>);">Editar Propriedade</button>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>

    <script>
        function editarPropriedade(id) {
            window.location.href = `editar_propriedade.php?id=${id}`;
        }
    </script>
</body>

</html>
