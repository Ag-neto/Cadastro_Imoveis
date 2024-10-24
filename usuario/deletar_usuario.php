<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}
?>

<?php

// Obtém o ID e garante que seja um número válido
$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

if ($id > 0) {
    $conn->begin_transaction(); // Inicia uma transação

    try {
        // Deletar registros relacionados na tabela `documentacao_inquilino`
        $stmt1 = $conn->prepare(
            "DELETE FROM documentacao_inquilino 
             WHERE id_inquilino = (SELECT id_inquilino FROM usuarios WHERE idusuario = ?)"
        );
        $stmt1->bind_param("i", $id);
        $stmt1->execute();

        // Deletar o usuário da tabela `usuarios`
        $stmt2 = $conn->prepare("DELETE FROM usuarios WHERE idusuario = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();

        // Confirma a transação
        $conn->commit();
        echo '<script>alert("Usuário deletado com sucesso!"); window.location.href="listar_usuarios.php";</script>';
    } catch (Exception $e) {
        $conn->rollback(); // Reverte a transação em caso de erro
        echo "Erro ao deletar usuário: " . $e->getMessage();
    }
} else {
    echo '<script>alert("ID inválido!"); window.location.href="listar_usuarios.php";</script>';
}
?>
