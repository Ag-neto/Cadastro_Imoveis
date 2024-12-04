<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <link rel="stylesheet" href="../style/listar_usuario.css">
</head>

<body>
    <header>
        <h1>Lista de Usuários</h1>
    </header>

    <section class="form-section">
        <h2>Buscar Usuário</h2>
        <form id="buscar-usuario-form" method="GET" action="listar_usuarios.php">
            <div class="form-group">
                <label for="busca">Buscar por nome ou e-mail:</label>
                <input type="text" id="busca" name="busca" placeholder="Digite o nome ou e-mail do usuário">
            </div>

            <button type="submit">Buscar</button>
            <a href="../index.php" class="btn-voltar">Voltar</a>
            <a href="cadastro_usuario.php" class="btn-criar_usuario">Cadastrar Usuário</a>
        </form>
    </section>

    <section class="usuarios-lista">
        <h2>Usuários Cadastrados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Nível de Acesso</th>
                    <th>cliente Associado</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once "../conexao/conexao.php";

                $busca = isset($_GET['busca']) ? $_GET['busca'] : '';
                $busca = $conn->real_escape_string($busca);

                // Consulta SQL para buscar usuários
                $sql = "SELECT u.idusuario, u.nome_usuario, u.email, 
                               u.idnivel_acesso, i.nome_cliente 
                        FROM usuarios u 
                        LEFT JOIN cliente i ON u.id_cliente = i.idcliente";

                if (!empty($busca)) {
                    $sql .= " WHERE u.nome_usuario LIKE '%$busca%' 
                              OR u.email LIKE '%$busca%'";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $nivelAcesso = ($row['idnivel_acesso'] == 1) ? 'Administrador' : 'Usuário Comum';
                        $nomecliente = $row['nome_cliente'] ?? 'Não Associado';

                        echo '<tr>';
                        echo '<td>' . $row['idusuario'] . '</td>';
                        echo '<td>' . $row['nome_usuario'] . '</td>';
                        echo '<td>' . $row['email'] . '</td>';
                        echo '<td>' . $nivelAcesso . '</td>';
                        echo '<td>' . $nomecliente . '</td>';
                        echo '<td>
                                <a href="detalhes_usuario.php?id=' . $row['idusuario'] . '">Ver Detalhes</a> |
                                <a href="deletar_usuario.php?id=' . $row['idusuario'] . '" 
                                   onclick="return confirm(\'Tem certeza que deseja excluir este usuário?\')">Excluir</a>
                              </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">Nenhum usuário encontrado.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Usuários</p>
    </footer>

    <script src="../scripts/script_usuarios.js"></script>
</body>

</html>
