<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Propriedade</title>
    <link rel="stylesheet" href="../style/cadastro_propriedade_style.css">
</head>

<body>
    <header>
        <h1>Cadastro de Propriedade</h1>
    </header>

    <section class="form-section">
        <h2>Adicionar Propriedade</h2>
        <form enctype="multipart/form-data" action="propriedade_script.php" method="POST">
            <div class="form-group">
                <div class="form-item">
                    <label for="nome_propriedade">Nome da Propriedade:</label>
                    <input type="text" id="nome_propriedade" name="nome_propriedade" placeholder="Ex: Apartamento Central" required>
                </div>

                <div class="form-item">
                    <label for="endereco">Endereço:</label>
                    <input type="text" id="endereco" name="endereco" placeholder="Ex: Rua ABC, 123" required>
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
                    <label for="valor_adquirido">Valor - Adquirido (R$):</label>
                    <input type="number" id="valor_adquirido" name="valor_adquirido" placeholder="Ex: 250000" required>
                </div>

                <div class="form-item">
                    <label for="tamanho">Tamanho: (m²)</label>
                    <input type="number" id="tamanho" name="tamanho" required>
                </div>

                <div class="form-item">
                    <label for="id_situacao">Situação da propriedade:</label>
                    <select name="id_situacao" id="id_situacao" required>
                        <option value="" disabled selected>Selecione</option>
                        <?php
                        $sql = "SELECT * FROM situacao";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['id_situacao'] . '">' . $row['nome_situacao'] . '</option>';
                            }
                        }

                        ?>
                    </select><br>
                </div>

                <div class="form-item">
                    <label for="data">Data de Registro:</label>
                    <input type="date" name="data" id="data">
                </div>

                <div class="form-item">
                    <label for="id_tipo_prop">Tipo da propriedade:</label>
                    <select name="id_tipo_prop" id="id_tipo_prop" required>
                        <option value="" disabled selected>Selecione</option>
                        <?php
                        $sql = "SELECT * FROM tipo_prop";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['id_tipo_prop'] . '">' . $row['nome_tipo'] . '</option>';
                            }
                        }

                        ?>
                    </select><br>
                </div>
            </div>

            <button type="submit">Vincular Documentos</button>
            <a href="listar_propriedades.php">Voltar</a>
        </form>
    </section>
    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedade</p>
    </footer>
</body>

</html>