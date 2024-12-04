<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}

// Recebe os dados enviados pelo formulário
$id = $_POST['idusuario'];
$nome = $_POST['nome_usuario'];
$email = $_POST['email'];
$idnivel_acesso = intval($_POST['idnivel_acesso']);
$id_cliente = empty($_POST['id_cliente']) ? null : intval($_POST['id_cliente']); // Aqui alteramos para null

$senha = $_POST['senha'] ?? '';

// Atualiza a senha apenas se o campo for preenchido
if (!empty($senha)) {
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "UPDATE usuarios 
            SET nome_usuario = ?, email = ?, idnivel_acesso = ?, id_cliente = ?, senha = ? 
            WHERE idusuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissi", $nome, $email, $idnivel_acesso, $id_cliente, $senha_hash, $id);
} else {
    $sql = "UPDATE usuarios 
            SET nome_usuario = ?, email = ?, idnivel_acesso = ?, id_cliente = ? 
            WHERE idusuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisi", $nome, $email, $idnivel_acesso, $id_cliente, $id);
}

// Executa a atualização
if ($stmt->execute()) {
    echo '<script>alert("Alterações salvas com sucesso!"); window.location.href="detalhes_usuario.php?id=' . $id . '";</script>';
} else {
    echo '<script>alert("Erro ao salvar alterações: ' . $conn->error . '"); window.location.href="editar_usuario.php?id=' . $id . '";</script>';
}
?>
