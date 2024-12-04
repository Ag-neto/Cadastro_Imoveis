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
    <title>Cadastro de Cidade</title>
    <link rel="stylesheet" href="../style/cadastrar_cidade.css">
</head>

<body>
    <header>
        <h1>Cadastro de Cidade</h1>
    </header>

    <main>
        <section class="form-section">
            <?php
            // Verifica se o método é POST para evitar execução desnecessária
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nome = $_POST['nome_cidade'];
                $estado = $_POST['id_estado'];

                $sql = "INSERT INTO localizacao (nome_cidade, id_estado) VALUES ('$nome', '$estado')";

                if (mysqli_query($conn, $sql)) {
                    echo "<p class='success'>$nome cadastrado(a) com sucesso!</p>";
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
