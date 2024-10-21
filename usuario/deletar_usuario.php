<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Usuário</title>
</head>
<body>
    <?php
    require_once "../conexao/conexao.php"; // Conexão com o banco de dados

    $id = $_GET["id"] ?? ""; // Obtém o ID do usuário pela query string

    if (!empty($id)) {
        // Deletar registros relacionados na tabela `documentacao_inquilino` e `usuarios`
        $stmt1 = $conn->prepare("DELETE FROM documentacao_inquilino WHERE id_inquilino = (SELECT id_inquilino FROM usuarios WHERE idusuario = ?)");
        $stmt1->bind_param("i", $id);

        // Executa a exclusão e verifica se foi bem-sucedida
        if ($stmt1->execute()) {
            // Agora deletar o usuário da tabela `usuarios`
            $stmt2 = $conn->prepare("DELETE FROM usuarios WHERE idusuario = ?");
            $stmt2->bind_param("i", $id);

            if ($stmt2->execute()) {
                echo '<script>alert("Usuário deletado com sucesso!"); window.location.href="listar_usuarios.php";</script>';
            } else {
                echo "Erro ao deletar usuário: " . $stmt2->error;
            }
        } else {
            echo "Erro ao deletar registros relacionados: " . $stmt1->error;
        }
    } else {
        echo '<script>alert("ID do usuário não fornecido!"); window.location.href="listar_usuarios.php";</script>';
    }
    ?>
</body>
</html>
