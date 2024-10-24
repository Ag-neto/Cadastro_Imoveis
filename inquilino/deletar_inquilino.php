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
    <title>Document</title>
</head>

<body>
    <?php

    $id = $_GET["id"] ?? "";

    // Primeiro, deleta os registros da tabela documentacao_inquilino
    $sql1 = "DELETE FROM documentacao_inquilino WHERE id_inquilino = $id";

    if (mysqli_query($conn, $sql1)) {
        // Agora tenta deletar da tabela inquilino
        $sql = "DELETE FROM inquilino WHERE idinquilino = $id";

        if (mysqli_query($conn, $sql)) {
            echo "Deletado com sucesso!";
            header('Location: listar_inquilinos.php');
        } else {
            echo "Erro ao deletar da tabela inquilino: " . mysqli_error($conn);
        }
    } else {
        echo "Erro ao deletar da tabela documentacao_inquilino: " . mysqli_error($conn);
    }
    ?>
</body>

</html>