<?php
session_start();

require_once "../conexao/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE nome_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nome);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
    
        if (password_verify($senha, $row['senha'])) {
            // Define as variáveis de sessão após o login bem-sucedido
            $_SESSION["loggedin"] = true;
            $_SESSION["idusuario"] = $row['idusuario'];
            $_SESSION["id_cliente"] = $row['id_cliente']; // Certifique-se de que esse campo é retornado
            $_SESSION["idnivel_acesso"] = $row['idnivel_acesso'];
    
            // Redireciona para a página principal (index.php)
            header("location: ../index.php");
            exit;
        }
    }
    

    // Define a mensagem de erro
    $error = "Usuário ou senha incorretos";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Propriedades</title>
    <link rel="stylesheet" href="../style/style_login.css">

</head>

<body>
    <div class="login-container">
        <h1>Gestor de Propriedades</h1>
        <h2>Login</h2>
        <?php if (isset($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <input type="text" name="nome" placeholder="Usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
        <div class="forgot-password">
            <a href="#">Esqueceu a senha?</a>
        </div>
    </div>
</body>

</html>