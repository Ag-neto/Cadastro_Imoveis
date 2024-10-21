<?php
require_once "../conexao/conexao.php"; // Conexão com o banco de dados

if (isset($_GET['id'])) {
    $id_usuario = intval($_GET['id']); // Segurança contra SQL Injection

    // Consulta para obter os dados do usuário e do inquilino associado
    $sql = "SELECT u.*, i.nome_inquilino, i.idinquilino, n.nome_nivel 
            FROM usuarios u
            LEFT JOIN inquilino i ON u.id_inquilino = i.idinquilino
            LEFT JOIN nivel_de_acesso n ON u.idnivel_acesso = n.id_nivel
            WHERE u.idusuario = $id_usuario";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        echo '<script>alert("Usuário não encontrado."); window.location.href="listar_usuarios.php";</script>';
        exit;
    }
} else {
    echo '<script>alert("ID de usuário não fornecido."); window.location.href="listar_usuarios.php";</script>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="../style/cadastro_usuario.css">
</head>

<body>
    <header>
        <h1>Editar Usuário</h1>
    </header>

    <section class="form-section">
        <form method="POST" action="atualizar_usuario.php">
            <input type="hidden" name="id_usuario" value="<?php echo $usuario['idusuario']; ?>">

            <div class="form-group">
                <label for="nome_usuario">Nome:</label>
                <input type="text" id="nome_usuario" name="nome_usuario" required 
                       value="<?php echo htmlspecialchars($usuario['nome_usuario']); ?>">
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required 
                       value="<?php echo htmlspecialchars($usuario['email']); ?>">
            </div>

            <div class="form-group">
                <label for="nivel_acesso">Nível de Acesso:</label>
                <select id="nivel_acesso" name="nivel_acesso" required>
                    <option value="1" <?php if ($usuario['idnivel_acesso'] == 1) echo 'selected'; ?>>Administrador</option>
                    <option value="2" <?php if ($usuario['idnivel_acesso'] == 2) echo 'selected'; ?>>Usuário Comum</option>
                </select>
            </div>

            <div class="form-group">
                <label for="inquilino">Inquilino Associado:</label>
                <?php if (!empty($usuario['nome_inquilino'])): ?>
                    <a href="detalhes_inquilino.php?id=<?php echo $usuario['idinquilino']; ?>">
                        <?php echo htmlspecialchars($usuario['nome_inquilino']); ?>
                    </a>
                <?php else: ?>
                    <p>Nenhum inquilino associado.</p>
                <?php endif; ?>
            </div>

            <button type="submit">Salvar Alterações</button>
            <a href="listar_usuarios.php" class="btn-voltar">Voltar</a>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Usuários</p>
    </footer>
</body>

</html>
