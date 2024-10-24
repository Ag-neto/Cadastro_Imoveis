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

// Consulta SQL para buscar os dados do usuário pelo ID
$sql = "SELECT u.idusuario, u.nome_usuario, u.email, u.idnivel_acesso, 
               i.idcliente, i.nome_cliente 
        FROM usuarios u 
        LEFT JOIN cliente i ON u.id_cliente = i.idcliente 
        WHERE u.idusuario = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    $nivelAcesso = ($usuario['idnivel_acesso'] == 1) ? 'Administrador' : 'Usuário Comum';
    $clienteID = $usuario['idcliente'] ?? null;
    $nomecliente = $usuario['nome_cliente'] ?? 'Não Associado';
} else {
    echo '<script>alert("Usuário não encontrado!"); window.location.href="listar_usuarios.php";</script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Usuário</title>
    <link rel="stylesheet" href="../style/listar_usuario.css">
</head>

<body>
    <header>
        <h1>Detalhes do Usuário</h1>
    </header>

    <section class="usuario-detalhes">
        <p><strong>ID:</strong> <?= $usuario['idusuario'] ?></p>
        <p><strong>Nome:</strong> <?= htmlspecialchars($usuario['nome_usuario']) ?></p>
        <p><strong>E-mail:</strong> <?= htmlspecialchars($usuario['email']) ?></p>
        <p><strong>Nível de Acesso:</strong> <?= $nivelAcesso ?></p>

        <p><strong>Cliente Associado:</strong> 
            <?php if ($clienteID): ?>
                <a href="../cliente/detalhes_cliente.php?id=<?= $clienteID ?>">
                    <?= htmlspecialchars($nomecliente) ?>
                </a>
            <?php else: ?>
                Não Associado
            <?php endif; ?>
        </p>

        <div class="usuario-acoes">
            <a href="editar_usuario.php?id=<?= $usuario['idusuario'] ?>" class="btn-editar">Editar Usuário</a>
            <a href="listar_usuarios.php" class="btn-voltar">Voltar</a>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Usuários</p>
    </footer>
</body>

</html>
