<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_contrato'])) {
        $id_contrato = intval($_POST['id_contrato']); // Converte para inteiro para evitar SQL Injection

        // Prepara a consulta SQL para deletar o contrato
        $sql = "DELETE FROM contratos WHERE id_contratos = $id_contrato";

        if (mysqli_query($conn, $sql)) {
            header('Location: listar_contratos.php?message=Contrato deletado com sucesso.');
            exit();
        } else {
            echo "<p class='error'>Erro ao deletar contrato: " . mysqli_error($conn) . "</p>";
        }
    }
} else {
    echo "<p class='error'>Método de requisição inválido.</p>";
}
?>
