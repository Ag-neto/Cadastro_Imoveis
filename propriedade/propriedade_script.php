<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Propriedade</title>
    <link rel="stylesheet" href="../style/cadastrar_cidade.css">
</head>

<body>
    <header>
        <h1>Cadastro de Propriedade</h1>
    </header>

    <main>
        <section class="form-section">
            <?php

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Sanitização dos dados de entrada
                $nome = mysqli_real_escape_string($conn, $_POST['nome_propriedade']);
                $nome_fantasia = mysqli_real_escape_string($conn, $_POST['nome_fantasia']);
                $localidade = mysqli_real_escape_string($conn, $_POST['id_localizacao']);
                $tipo = mysqli_real_escape_string($conn, $_POST['id_tipo_prop']);
                $tamanho = mysqli_real_escape_string($conn, $_POST['tamanho']);
                $endereco = mysqli_real_escape_string($conn, $_POST['endereco']);
                $situacao = mysqli_real_escape_string($conn, $_POST['id_situacao']);
                $data = mysqli_real_escape_string($conn, $_POST['data']);
                $tipo_imposto = mysqli_real_escape_string($conn, $_POST['tipo_imposto']);
                $periodo_imposto = mysqli_real_escape_string($conn, $_POST['periodo_imposto']);
                $incra = mysqli_real_escape_string($conn, $_POST['incra']);

                // Convertendo valores para formato numérico adequado
                $valor_adquirido = str_replace(['.', ','], ['', '.'], $_POST['valor_adquirido']);
                $valor_imposto = str_replace(['.', ','], ['', '.'], $_POST['valor_imposto']);

                // Verificação se os valores foram convertidos corretamente
                if (!is_numeric($valor_adquirido) || (!empty($valor_imposto) && !is_numeric($valor_imposto))) {
                    echo "<p class='error'>Erro ao processar os valores monetários. Por favor, revise os campos de valor.</p>";
                    exit;
                }

                // SQL para inserir os dados
                $sql = "INSERT INTO propriedade 
                    (nome_propriedade, id_localizacao, id_tipo_prop, tamanho, valor_adquirido, endereco, id_situacao, data_registro, tipo_imposto, valor_imposto, periodo_imposto, incra, nome_fantasia) 
                    VALUES 
                    ('$nome', '$localidade', '$tipo', '$tamanho', '$valor_adquirido', '$endereco', '$situacao', '$data', '$tipo_imposto', '$valor_imposto', '$periodo_imposto', '$incra', '$nome_fantasia')";

                // Executa o comando e verifica sucesso
                if (mysqli_query($conn, $sql)) {
                    echo "<p class='success'>$nome cadastrado(a) com sucesso!</p>";
                    header('Location: add_documento.php');
                } else {
                    echo "<p class='error'>Erro: " . mysqli_error($conn) . "</p>";
                }
            }
            ?>
        </section>

        <a href="../index.php" class="button">Voltar para o menu</a>
    </main>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>
</body>

</html>
