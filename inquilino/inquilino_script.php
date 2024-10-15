<?php
require_once "../conexao/conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Inquilino</title>
    <link rel="stylesheet" href="../style/cadastrar_cidade.css">
</head>

<body>
    <header>
        <h1>Cadastro de Inquilino</h1>
    </header>

    <main>
        <section class="form-section">
            <?php

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = $_POST['nome_inquilino'];
                $endereco = $_POST['endereco'];
                $localidade = intval ($_POST['id_localizacao']);
                $data_nascimento = $_POST['data_nascimento'];
                $rg_numero = $_POST['rg_numero'];
                $cpf_numero = $_POST['cpf_numero'];
                $telefone = $_POST['telefone'];

                $sql = "INSERT INTO inquilino (nome_inquilino, rg_numero, cpf_numero, endereco, id_localizacao,
                data_nascimento, telefone) VALUES ('$nome', '$rg_numero', '$cpf_numero', '$endereco',
                '$localidade', '$data_nascimento', '$telefone')";

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