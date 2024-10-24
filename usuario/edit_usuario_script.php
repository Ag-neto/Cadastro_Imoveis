<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}
?>

<?php

// Recebe os dados enviados pelo formulário
$id = $_POST['idusuario'];
$nome = $_POST['nome_usuario'];
$email = $_POST['email'];
$idnivel_acesso = intval($_POST['idnivel_acesso']);
$id_cliente = empty($_POST['id_cliente']) ? 'NULL' : intval($_POST['id_cliente']);
$data_criacao = $_POST['data_criacao'];

// Executa a atualização no banco
$sql = "UPDATE usuarios 
        SET nome_usuario = '$nome', 
            email = '$email', 
            idnivel_acesso = $idnivel_acesso, 
            id_cliente = $id_cliente, 
            data_criacao = '$data_criacao' 
        WHERE idusuario = $id";

if (mysqli_query($conn, $sql)) {
    echo "$nome alterado com sucesso!";
    header('Location: detalhes_usuario.php?id=' . $id);
    exit();
} else {
    echo "Erro ao alterar $nome.";
}
?>
