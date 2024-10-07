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
        <form action="propriedade_script.php" method="POST">
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
                    <label for="localidade">Localidade:</label>
                    <select name="id_localizacao" id="id_localizacao" required>
                        <option value="" disabled selected>Selecione</option>
                            <?php
                            require_once "../conexao/conexao.php";

                            $sql = "SELECT * FROM localizacao";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['id_localizacao'] . '">' . $row['nome_cidade'] . '</option>';
                                }
                            }

                            ?>
                        </select><br>
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
                    <label for="situacao">Situação:</label>
                    <select id="situacao" name="situacao" required>
                        <option value=""disabled selected>Selecione uma opção</option>
                        <option value="disponivel_venda">Disponível para venda</option>
                        <option value="disponivel_aluguel">Disponível para aluguel</option>
                    </select>
                </div>

                <div class="form-item">
                    <label for="data">Data de Registro:</label>
                    <input type="date" id="data">
                </div>

                <div class="form-item">
                    <label for="documentos">Documentação</label>
                    <input type="file" name="documento" id="documento">
                </div>

                <div class="form-item">
                    <label for="tipo">Tipo de Propriedade:</label>
                    <select id="tipo" name="tipo" required>
                        <option value="" disabled selected>Selecione uma opção</option>
                        <option value="apartamento">Apartamento</option>
                        <option value="casa">Casa</option>
                        <option value="comercial">Comercial</option>
                        <option value="fazenda">Fazenda</option>
                    </select>
                </div>
            </div>

            <button type="submit">Salvar Propriedade</button>
            <a href="listar_propriedades.php">Voltar</a>
        </form>
    </section>
    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedade</p>
    </footer>
</body>
</html>
