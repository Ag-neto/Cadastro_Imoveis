<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}
?>

<?php

$id = $_GET["id"] ?? "";

$sql = "SELECT * FROM cliente WHERE idcliente = $id";

$dados = mysqli_query($conn, $sql);

$linha = mysqli_fetch_assoc($dados);

$data_nascimento = isset($linha['data_nascimento']) ? date('Y-m-d', strtotime($linha['data_nascimento'])) : '';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Controle de Propriedade</title>
        <link rel="stylesheet" href="../style/cadastro_cliente.css">
    </head>

    <body>
        <header>
            <h1>Editar informações de cliente</h1>
        </header>

        <section class="form-section">
            <h2>clientes</h2>
            <form enctype="multipart/form-data" action="edit_cliente_script.php" method="POST">
                <div class="form-group">
                    <div class="form-item">
                        <label for="nome_cliente">Nome do cliente:</label>
                        <input type="text" id="nome_cliente" name="nome_cliente" value="<?php echo $linha['nome_cliente']; ?>" required oninput="this.value = this.value.toUpperCase()">
                    </div>

                    <div class="form-item">
                        <label for="endereco">Endereço:</label>
                        <input type="text" id="endereco" name="endereco" value="<?php echo $linha['endereco']; ?>" required oninput="this.value = this.value.toUpperCase()">
                    </div>

                    <div class="form-item">
                        <label for="telefone">Telefone:</label>
                        <input type="text" id="telefone" name="telefone" value="<?php echo $linha['telefone']; ?>" required>
                    </div>

                    <div class="form-item">
                        <label for="prosissao">Profissão:</label>
                        <input type="text" id="profissao" name="profissao" value="<?php echo $linha['profissao']; ?>" required oninput="this.value = this.value.toUpperCase()">
                    </div>

                    <div class="form-item">
                        <label for="nacionalidade">Nacionalidade:</label>
                        <input type="text" id="nacionalidade" name="nacionalidade" value="<?php echo $linha['nacionalidade']; ?>" required oninput="this.value = this.value.toUpperCase()">
                    </div>

                    <div class="form-item">
                        <label for="cep">CEP:</label>
                        <input type="text" id="cep" name="cep" value="<?php echo $linha['cep']; ?>" required>
                    </div>

                    <div class="form-item">
                        <label for="localizacao">Cidade:</label>
                        <select name="id_localizacao" id="id_localizacao" required>
                            <option value="" disabled selected>Selecione</option>
                            <?php

                            $sql = "SELECT l.*, e.nome_estado, e.sigla 
                                    FROM localizacao l 
                                    JOIN estados e ON l.id_estado = e.id_estado";

                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                // Verifica se o id_localizacao corresponde ao do cliente
                                $selected = $row['idlocalizacao'] == $linha['id_localizacao'] ? 'selected' : '';
                                echo '<option value="' . $row['idlocalizacao'] . '" ' . $selected . '>' . htmlspecialchars($row['nome_cidade']) . " - " . $row['sigla'] . '</option>';
                            }

                            ?>
                        </select>
                    </div>

                    <div class="form-item">
                        <label for="data">Data de Nascimento:</label>
                        <input type="date" name="data_nascimento" id="data_nascimento" value="<?php echo $data_nascimento; ?>">

                    </div>

                    <div class="form-item">
                        <label for="rg_numero">Registro Geral (RG):</label>
                        <input type="text" id="rg_numero" name="rg_numero" value="<?php echo $linha['rg_numero']; ?>" required>
                    </div>

                    <div class="form-item">
                        <label for="cpf_numero">Cadastro de pessoa física (CPF):</label>
                        <input type="text" id="cpf_numero" name="cpf_numero" value="<?php echo $linha['cpf_numero']; ?>" required>
                    </div>

                </div>

                <button type="submit">Salvar Alterações</button>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <a href="listar_clientes.php">Voltar</a>
            </form>
        </section>
        <footer>
            <p>&copy; 2024 - Sistema de Gestão de Propriedade</p>
        </footer>

        <script>
            document.getElementById('telefone').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
                value = value.replace(/^(\d{2})(\d)/g, '($1) $2'); // Adiciona parênteses ao DDD
                value = value.replace(/(\d{5})(\d)/, '$1-$2'); // Adiciona o hífen após o quinto dígito
                e.target.value = value.substring(0, 15); // Limita o tamanho máximo a 15 caracteres
            });
        </script>

        <script>
            // Máscara para o campo RG
            document.getElementById('rg_numero').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
                value = value.replace(/(\d{2})(\d)/, '$1.$2'); // Adiciona ponto após os dois primeiros dígitos
                value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona ponto após o quinto dígito
                value = value.replace(/(\d{3})(\d)/, '$1-$2'); // Adiciona hífen após o oitavo dígito
                e.target.value = value.substring(0, 12); // Limita o tamanho máximo a 12 caracteres
            });

            // Máscara para o campo CPF
            document.getElementById('cpf_numero').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
                value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona ponto após os três primeiros dígitos
                value = value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona ponto após o sexto dígito
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Adiciona hífen antes dos dois últimos dígitos
                e.target.value = value.substring(0, 14); // Limita o tamanho máximo a 14 caracteres
            });

            // Máscara para o campo CEP
            document.getElementById('cep').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, ''); // Remove caracteres não numéricos
                value = value.replace(/(\d{5})(\d)/, '$1-$2'); // Adiciona hífen após os cinco primeiros dígitos
                e.target.value = value.substring(0, 10); // Limita o tamanho máximo a 10 caracteres
            });
        </script>

    </body>

    </html>
</body>

</html>