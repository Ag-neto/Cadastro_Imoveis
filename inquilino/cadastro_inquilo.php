<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Propriedade</title>
    <link rel="stylesheet" href="../style/cadastro_inquilino.css">
</head>
<body>
    <header>
        <h1>Cadastro de Inquilino</h1>
    </header>

    <section class="form-section">
        <h2>Adicionar Inquilino</h2>
        <form action="inquilino_script.php" method="POST">
            <div class="form-group">
                <div class="form-item">
                    <label for="nome_inquilino">Nome do Inquilino:</label>
                    <input type="text" id="nome_inquilino" name="nome_inquilino" placeholder="Ex: Rodrigo Carvalho" required>
                </div>

                <div class="form-item">
                    <label for="endereco">Endereço:</label>
                    <input type="text" id="endereco" name="endereco" placeholder="Ex: Rua ABC, 123" required>
                </div>

                <div class="form-item">
                    <label for="telefone">Telefone:</label>
                    <input type="text" id="telefone" name="telefone" placeholder="Ex: (xx) x xxxx-xxxx" required>
                </div>

                <div class="form-item">
                    <label for="localizacao">Localidade:</label>
                    <select name="id_localizacao" id="id_localizacao" required>
                        <option value="" disabled selected>Selecione</option>
                        <?php
                        require_once "../conexao/conexao.php";

                        $sql = "SELECT l.*, e.nome_estado, e.sigla 
                        FROM localizacao l 
                        JOIN estados e ON l.id_estado = e.id_estado";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['idlocalizacao'] . '">' . $row['nome_cidade'] . " - " . $row['sigla'] . '</option>';
                            }
                        }

                        ?>
                    </select>
                </div>

                <div class="form-item">
                    <label for="data_nascimento">Data de nascimento:</label>
                    <input type="date" name="data_nascimento" id="data_nascimento">
                </div> 

                <div class="form-item">
                    <label for="rg_numero">Registro Geral (RG):</label>
                    <input type="text" id="rg_numero" name="rg_numero" required>
                </div>

                <div class="form-item">
                    <label for="cpf_numero">Cadastro de pessoa física (CPF):</label>
                    <input type="text" id="cpf_numero" name="cpf_numero" required>
                </div>
            </div>

            <button type="submit">Vincular Documentos</button>
            <a href="listar_inquilinos.php">Voltar</a>
        </form>
    </section>
    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedade</p>
    </footer>
</body>
</html>
