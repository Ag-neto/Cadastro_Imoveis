<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}
?>

<?php

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idusuario = $_POST['idusuario'];
    $nome_usuario = $_POST['nome_usuario'];
    $email = $_POST['email'];
    $idnivel_acesso = $_POST['idnivel_acesso'];
    $id_inquilino = !empty($_POST['id_inquilino']) ? $_POST['id_inquilino'] : null;

    // Atualiza os dados do usuário no banco
    $sql = "UPDATE usuarios 
            SET nome_usuario = ?, email = ?, idnivel_acesso = ?, id_inquilino = ? 
            WHERE idusuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiii", $nome_usuario, $email, $idnivel_acesso, $id_inquilino, $idusuario);

    if ($stmt->execute()) {
        echo '<script>alert("Usuário atualizado com sucesso!"); window.location.href="listar_usuarios.php";</script>';
    } else {
        echo '<script>alert("Erro ao atualizar usuário!"); window.history.back();</script>';
    }
}
?>
