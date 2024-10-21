<?php
require_once "../conexao/conexao.php"; // Conexão com o banco de dados

// Obtém o ID do usuário pela query string
$id = $_GET['id'] ?? '';

if (empty($id)) {
    echo '<script>alert("ID de usuário não fornecido!"); window.location.href="listar_usuarios.php";</script>';
    exit();
}

// Consulta SQL para buscar os dados do usuário pelo ID
$sql = "SELECT u.idusuario, u.nome_usuario, u.email, u.idnivel_acesso, 
               i.idinquilino, i.nome_inquilino 
        FROM usuarios u 
        LEFT JOIN inquilino i ON u.id_inquilino = i.idinquilino 
        WHERE u.idusuario = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    $nivelAcesso = ($usuario['idnivel_acesso'] == 1) ? 'Administrador' : 'Usuário Comum';
    $inquilinoID = $usuario['idinquilino'] ?? null;
    $nomeInquilino = $usuario['nome_inquilino'] ?? 'Não Associado';
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

        <p><strong>Inquilino Associado:</strong> 
            <?php if ($inquilinoID): ?>
                <a href="../inquilino/detalhes_inquilino.php?id=<?= $inquilinoID ?>">
                    <?= htmlspecialchars($nomeInquilino) ?>
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