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
                $nome = $_POST['nome_propriedade'];
                $localidade = $_POST['id_localizacao'];
                $tipo = $_POST['id_tipo_prop'];
                $tamanho = $_POST['tamanho'];
                $valor_adquirido = $_POST['valor_adquirido'];
                $endereco = $_POST['endereco'];
                $situacao = $_POST['id_situacao'];
                $data = $_POST['data'];
                $tipo_imposto = $_POST['tipo_imposto'];
                $valor_imposto = $_POST['valor_imposto'];
                $periodo_imposto = $_POST['periodo_imposto'];


                $sql = "INSERT INTO propriedade (nome_propriedade, id_localizacao, id_tipo_prop, tamanho, valor_adquirido, endereco, id_situacao, data_registro, tipo_imposto, valor_imposto, periodo_imposto) VALUES ('$nome', '$localidade', '$tipo', '$tamanho', '$valor_adquirido', '$endereco', '$situacao', '$data', '$tipo_imposto', '$valor_imposto', '$periodo_imposto')";

                if (mysqli_query($conn, $sql)) {
                    echo "<p class='success'>$nome cadastrado(a) com sucesso!</p>";
                    header('Location: add_documento.php');
                } else {
                    echo "<p class='error'>$nome não foi cadastrado(a)!</p>";
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