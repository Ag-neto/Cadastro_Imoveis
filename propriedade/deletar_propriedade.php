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

    // Primeiro, deleta os registros da tabela conta_corrente_propriedade que referenciam esta propriedade
    $sql2 = "DELETE FROM conta_corrente_propriedade WHERE id_propriedade = $id";
    if (mysqli_query($conn, $sql2)) {
        // Depois, deleta os registros da tabela documentacao_propriedade
        $sql1 = "DELETE FROM documentacao_propriedade WHERE id_propriedade = $id";
        
        if (mysqli_query($conn, $sql1)) {
            // Agora tenta deletar da tabela propriedade
            $sql = "DELETE FROM propriedade WHERE idpropriedade = $id";
            
            if (mysqli_query($conn, $sql)) {
                echo "Deletado com sucesso!";
                header('Location: listar_propriedades.php');
                exit;
            } else {
                echo "Erro ao deletar da tabela propriedade: " . mysqli_error($conn);
            }
        } else {
            echo "Erro ao deletar da tabela documentacao_propriedade: " . mysqli_error($conn);
        }
    } else {
        echo "Erro ao deletar da tabela conta_corrente_propriedade: " . mysqli_error($conn);
    }
    ?>
</body>

</html>
