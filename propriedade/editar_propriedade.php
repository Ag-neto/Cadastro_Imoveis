<?php
require_once "../conexao/conexao.php";

$id = $_GET["id"] ?? "";

$sql = "SELECT * FROM propriedade WHERE idpropriedade = $id";

$dados = mysqli_query($conn, $sql);

$linha = mysqli_fetch_assoc($dados);

$data_registro = isset($linha['data_registro']) ? date('Y-m-d', strtotime($linha['data_registro'])) : '';

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
        <link rel="stylesheet" href="../style/cadastro_propriedade_style.css">
    </head>

    <body>
        <header>
            <h1>Editar informações da Propriedade</h1>
        </header>

        <section class="form-section">
            <h2>Propriedade</h2>
            <form enctype="multipart/form-data" action="edit_propriedade_script.php" method="POST">
                <div class="form-group">
                    <div class="form-item">
                        <label for="nome_propriedade">Nome da Propriedade:</label>
                        <input type="text" id="nome_propriedade" name="nome_propriedade" value="<?php echo $linha['nome_propriedade']; ?>" required oninput="this.value = this.value.toUpperCase()">
                    </div>

                    <div class="form-item">
                        <label for="endereco">Endereço:</label>
                        <input type="text" id="endereco" name="endereco" value="<?php echo $linha['endereco']; ?>" required oninput="this.value = this.value.toUpperCase()">
                    </div>

                    <div class="form-item">
                        <label for="localizacao">Localidade:</label>
                        <select name="id_localizacao" id="id_localizacao" required>
                            <option value="" disabled selected>Selecione</option>
                            <?php

                            $sql = "SELECT l.*, e.nome_estado, e.sigla 
                            FROM localizacao l 
                            JOIN estados e ON l.id_estado = e.id_estado";
                            
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                // Verifica se o id_localizacao corresponde ao da propriedade
                                $selected = $row['idlocalizacao'] == $linha['id_localizacao'] ? 'selected' : '';
                                echo '<option value="' . $row['idlocalizacao'] . '" ' . $selected . '>' . htmlspecialchars($row['nome_cidade']) . " - " . $row['sigla'] . '</option>';
                            }

                            ?>
                        </select>
                    </div>

                    <div class="form-item">
                        <label for="valor_adquirido">Valor - Adquirido (R$):</label>
                        <input type="number" id="valor_adquirido" name="valor_adquirido" value="<?php echo $linha['valor_adquirido']; ?>" required>
                    </div>

                    <div class="form-item">
                        <label for="tamanho">Tamanho: (m²)</label>
                        <input type="number" id="tamanho" name="tamanho" value="<?php echo $linha['tamanho']; ?>" required>
                    </div>

                    <div class="form-item">
                        <label for="id_situacao">Situação da propriedade:</label>
                        <select name="id_situacao" id="id_situacao" required>
                            <option value="" disabled selected>Selecione</option>
                            <?php
                            $sql = "SELECT * FROM situacao";
                            $result = $conn->query($sql);

                            while ($row = $result->fetch_assoc()) {
                                // Verifica se o id_situacao corresponde ao da propriedade
                                $selected = $row['id_situacao'] == $linha['id_situacao'] ? 'selected' : '';
                                echo '<option value="' . $row['id_situacao'] . '" ' . $selected . '>' . htmlspecialchars($row['nome_situacao']) . '</option>';
                            }

                            ?>
                        </select><br>
                    </div>

                    <div class="form-item">
                        <label for="data">Data de Registro:</label>
                        <input type="date" name="data" id="data" value="<?php echo $data_registro; ?>">

                    </div>


                    <div class="form-item">
                        <label for="id_tipo_prop">Tipo da propriedade:</label>
                        <select name="id_tipo_prop" id="id_tipo_prop" required>
                            <option value="" disabled selected>Selecione</option>
                            <?php
                            $sql = "SELECT * FROM tipo_prop";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                                // Verifica se o id_tipo_prop corresponde ao da propriedade
                                $selected = $row['id_tipo_prop'] == $linha['id_tipo_prop'] ? 'selected' : '';
                                echo '<option value="' . $row['id_tipo_prop'] . '" ' . $selected . '>' . htmlspecialchars($row['nome_tipo']) . '</option>';
                            }

                            ?>
                        </select><br>
                    </div>
                </div>

                <button type="submit">Salvar Alterações</button>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <a href="listar_propriedades.php">Voltar</a>
            </form>
        </section>
        <footer>
            <p>&copy; 2024 - Sistema de Gestão de Propriedade</p>
        </footer>
    </body>

    </html>
</body>

</html>