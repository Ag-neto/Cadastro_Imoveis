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

    $id = $_GET["id"] ?? ""; // Obtém o ID do usuário via query string

    if ($id) {
        // Deletar registros relacionados (se houver dependências em outras tabelas)
        $sql1 = "DELETE FROM alguma_tabela_relacionada WHERE id_usuario = $id";

        if (mysqli_query($conn, $sql1)) {
            // Agora deletar da tabela `usuarios`
            $sql2 = "DELETE FROM usuarios WHERE idusuario = $id";

            if (mysqli_query($conn, $sql2)) {
                echo '<script>alert("Usuário deletado com sucesso!"); window.location.href="listar_usuarios.php";</script>';
            } else {
                echo "Erro ao deletar usuário: " . mysqli_error($conn);
            }
        } else {
            echo "Erro ao deletar registros relacionados: " . mysqli_error($conn);
        }
    } else {
        echo "ID do usuário não fornecido!";
    }
    ?>
</body>

</html>
