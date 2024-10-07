<?php

// Incluindo arquivo do banco de dados
require_once 'conexao.php';

// Checando se o formulario foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegando o usuario do banco
    $usuario = $_POST['usuario'];

    // Checando se o usuário existe no banco de dados
    $consulta = "SELECT * FROM users WHERE usuario = ?";
    $declaracao = $conn->prepare($consulta);
    $declaracao->bind_param('s', $usuario);
    $declaracao->execute();
    $resultado = $declaracao->get_resultado();

    if ($resultado->num_rows > 0) {
        // Deletando o usuário do banco de dados
        $consulta = "DELETE FROM usuarios WHERE usuario = ?";
        $declaracao = $conn->prepare($consulta);
        $declaracao->bind_param('s', $usuario);
        $declaracao->execute();

        // Checando se o usuario foi deletado com sucesso
        if ($declaracao->affected_rows > 0) {
            $successo = 'Usuario deletado com sucesso.';
        } else {
            $error = 'Falha ao deletar o usuario.';
        }
    } else {
        $error = 'Usuario inexistente.';
    }
}
?>