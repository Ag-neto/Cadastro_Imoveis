<?php
require_once "../conexao/conexao.php"; // Conexão com o banco de dados

function gerarSenhaAleatoria($comprimento = 12) {
    return bin2hex(random_bytes($comprimento / 2));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletando dados do formulário
    $nome_usuario = $_POST['nome_usuario'];
    $email = $_POST['email'];
    $nivel_acesso = $_POST['nivel_acesso'];
    $inquilino = $_POST['inquilino'] ?? null; // Pode ser null

    // Geração da senha aleatória
    $senha_aleatoria = gerarSenhaAleatoria();
    $senha_hash = password_hash($senha_aleatoria, PASSWORD_DEFAULT); // Hash da senha

    // Verificar se o e-mail já está cadastrado
    $email = $conn->real_escape_string($email);
    $checkEmailQuery = "SELECT * FROM usuarios WHERE email='$email'";
    $checkResult = $conn->query($checkEmailQuery);

    if ($checkResult->num_rows > 0) {
        echo '<script>alert("E-mail já cadastrado!");</script>';
    } else {
        // Definindo inquilino como NULL se não selecionado
        $inquilino = empty($inquilino) ? "NULL" : intval($inquilino);

        // Inserir dados no banco
        $sql = "INSERT INTO usuarios (nome_usuario, email, senha, idnivel_acesso, id_inquilino) 
                VALUES ('$nome_usuario', '$email', '$senha_hash', '$nivel_acesso', $inquilino)";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Usuário cadastrado com sucesso! Senha enviada por e-mail."); window.location.href="listar_usuarios.php";</script>';
        } else {
            echo '<script>alert("Erro ao cadastrar usuário: ' . $conn->error . '");</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="../style/cadastro_usuario.css">
</head>

<body>
    <header>
        <h1>Cadastrar Usuário</h1>
    </header>

    <section class="form-section">
        <form id="cadastrar-usuario-form" method="POST" action="cadastro_usuario.php">
            <div class="form-group">
                <label for="nome_usuario">Nome:</label>
                <input type="text" id="nome_usuario" name="nome_usuario" required placeholder="Digite o nome do usuário">
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required placeholder="Digite o e-mail do usuário">
            </div>

            <div class="form-group">
                <label for="nivel_acesso">Nível de Acesso:</label>
                <select id="nivel_acesso" name="nivel_acesso" required>
                    <option value="1">Administrador</option>
                    <option value="2">Usuário Comum</option>
                </select>
            </div>

            <div class="form-group">
                <label for="inquilino">Inquilino Associado:</label>
                <select id="inquilino" name="inquilino">
                    <option value="">Nenhum</option>
                    <?php
                    // Consulta para listar inquilinos
                    $sql = "SELECT idinquilino, nome_inquilino FROM inquilino";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . $row['idinquilino'] . '">' . htmlspecialchars($row['nome_inquilino']) . '</option>';
                        }
                    }
                    ?>
                </select>
                <a id="ver-detalhes" href="#" target="_blank" style="display:none;">Ver Detalhes</a>
            </div>

            <button type="submit">Cadastrar Usuário</button>
            <a href="listar_usuarios.php" class="btn-voltar">Voltar</a>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Usuários</p>
    </footer>

    <script>
        const inquilinoSelect = document.getElementById('inquilino');
        const verDetalhesLink = document.getElementById('ver-detalhes');

        inquilinoSelect.addEventListener('change', function() {
            const selectedId = this.value;
            if (selectedId) {
                verDetalhesLink.href = `detalhes_inquilino.php?id=${selectedId}`;
                verDetalhesLink.style.display = 'inline';
            } else {
                verDetalhesLink.style.display = 'none';
            }
        });
    </script>
</body>

</html>
