<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}

// Obtém o ID do usuário pela query string
$id = $_GET['id'] ?? '';

if (empty($id)) {
    echo '<script>alert("ID de usuário não fornecido!"); window.location.href="listar_usuarios.php";</script>';
    exit();
}

// Consulta para buscar os dados do usuário
$sql_usuario = "SELECT idusuario, nome_usuario, email, idnivel_acesso, id_cliente FROM usuarios WHERE idusuario = ?";
$stmt = $conn->prepare($sql_usuario);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
} else {
    echo '<script>alert("Usuário não encontrado!"); window.location.href="listar_usuarios.php";</script>';
    exit();
}

// Consulta para buscar todos os clientes
$sql_clientes = "SELECT idcliente, nome_cliente FROM cliente";
$result_clientes = $conn->query($sql_clientes);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="../style/listar_usuario.css">
</head>

<body>
    <header>
        <h1>Editar Usuário</h1>
    </header>

    <form action="processar_edicao_usuario.php" method="POST">
        <input type="hidden" name="idusuario" value="<?= $usuario['idusuario'] ?>">

        <label for="nome_usuario">Nome do Usuário:</label>
        <input type="text" id="nome_usuario" name="nome_usuario" value="<?= htmlspecialchars($usuario['nome_usuario']) ?>" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

        <label for="idnivel_acesso">Nível de Acesso:</label>
        <select id="idnivel_acesso" name="idnivel_acesso" required>
            <option value="1" <?= $usuario['idnivel_acesso'] == 1 ? 'selected' : '' ?>>Administrador</option>
            <option value="2" <?= $usuario['idnivel_acesso'] == 2 ? 'selected' : '' ?>>Usuário Comum</option>
        </select>

        <label for="id_cliente">cliente Associado:</label>
        <select id="id_cliente" name="id_cliente">
            <option value="">Não Associado</option>
            <?php while ($cliente = $result_clientes->fetch_assoc()): ?>
                <option value="<?= $cliente['idcliente'] ?>" 
                    <?= $cliente['idcliente'] == $usuario['id_cliente'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cliente['nome_cliente']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <!-- Campo para alterar a senha -->
        <label for="senha">Nova Senha:</label>
        <input type="password" id="senha" name="senha" placeholder="Deixe em branco para não alterar">

        <div class="usuario-acoes">
            <button type="submit">Salvar Alterações</button>
            <a href="listar_usuarios.php" class="btn-voltar">Cancelar</a>
        </div>
    </form>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Usuários</p>
    </footer>
</body>

</html>
