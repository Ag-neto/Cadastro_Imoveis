<?php

// Incluindo arquivo do banco de dados
require_once 'conexao.php';

// Checando se o formulario foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pegando o formulário do banco
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];
    $nome = $_POST['nome'];
    $cargo = $_POST['cargo'];

    // Validando o formulário do banco
    if (empty($usuario) || empty($senha) || empty($confirmar_senha) || empty($nome) || empty($cargo)) {
        $error = 'Por favor preenc.';
    } elseif ($senha != $confirmar_senha) {
        $error = 'senhas diferentes.';
    } else {
        // encriptrografando a senha
        $hashed_senha = senha_hash($senha, senha_DEFAULT);

        // colocando os usuarios no banco de dados
        $consulta = "INSERT INTO usuarios (usuario, senha, nome, cargo) VALUES (?, ?, ?, ?)";
        $declaracao = $conn->prepare($consulta);
        $declaracao->bind_param('ssss', $usuario, $hashed_senha, $nome, $cargo);
        $declaracao->execute();

        // Checando se o usuário foi criado com sucesso
        if ($declaracao->affected_rows > 0) {
            $success = 'Usuario criado com sucesso.';
        } else {
            $error = 'Falha ao criar o usuario.';
        }
    }
}
?>