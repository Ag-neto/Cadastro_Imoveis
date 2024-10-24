<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}
?>

<?php

// Obtém o ID do usuário pela query string
$id = $_GET['id'] ?? '';

if (empty($id)) {
    echo '<script>alert("ID de usuário não fornecido!"); window.location.href="listar_usuarios.php";</script>';
    exit();
}

// Consulta para buscar os dados do usuário
$sql_usuario = "SELECT idusuario, nome_usuario, email, idnivel_acesso, id_inquilino 
                FROM usuarios WHERE idusuario = ?";
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

// Consulta para buscar todos os inquilinos
$sql_inquilinos = "SELECT idinquilino, nome_inquilino FROM inquilino";
$result_inquilinos = $conn->query($sql_inquilinos);
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

        <label for="id_inquilino">Inquilino Associado:</label>
        <select id="id_inquilino" name="id_inquilino">
            <option value="">Não Associado</option>
            <?php while ($inquilino = $result_inquilinos->fetch_assoc()): ?>
                <option value="<?= $inquilino['idinquilino'] ?>" 
                    <?= $inquilino['idinquilino'] == $usuario['id_inquilino'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($inquilino['nome_inquilino']) ?>
                </option>
            <?php endwhile; ?>
        </select>

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
