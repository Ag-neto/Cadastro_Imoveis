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
    <title>Cadastro de Cliente</title>
    <link rel="stylesheet" href="../style/cadastrar_cidade.css">
</head>

<body>
    <header>
        <h1>Cadastro de Cliente</h1>
    </header>

    <main>
        <section class="form-section">
            <?php

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = $_POST['nome_cliente'];
                $endereco = $_POST['endereco'];
                $localidade = intval ($_POST['id_localizacao']);
                $data_nascimento = $_POST['data_nascimento'];
                $profissao = $_POST['profissao'];
                $nacionalidade = $_POST['nacionalidade'];
                $cep = $_POST['cep'];
                $rg_numero = $_POST['rg_numero'];
                $cpf_numero = $_POST['cpf_numero'];
                $telefone = $_POST['telefone'];

                $sql = "INSERT INTO cliente (nome_cliente, rg_numero, cpf_numero, endereco, id_localizacao,
                data_nascimento, telefone, profissao, nacionalidade, cep) VALUES ('$nome', '$rg_numero', '$cpf_numero', '$endereco',
                '$localidade', '$data_nascimento', '$telefone', '$profissao', '$nacionalidade', '$cep')";

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