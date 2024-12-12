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
                    <input type="text" id="nome_propriedade" name="nome_propriedade" placeholder="Ex: Apartamento Central" required oninput="this.value = this.value.toUpperCase()">
                </div>

                <div class="form-item">
                    <label for="nome_fantasia">Nome Fantasia:</label>
                    <input type="text" id="nome_fantasia" name="nome_fantasia" placeholder="Ex: Apartamento do Marcelo" oninput="this.value = this.value.toUpperCase()">
                </div>

                <div class="form-item">
                    <label for="endereco">Endereço:</label>
                    <input type="text" id="endereco" name="endereco" placeholder="Ex: Rua ABC, 123" required oninput="this.value = this.value.toUpperCase()">
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
                    <input type="text" id="valor_adquirido" name="valor_adquirido" placeholder="Ex: 250000" required>
                </div>

                <div class="form-item">
                    <label for="tipo_imposto">Tipo de imposto:</label>
                    <select name="tipo_imposto" id="tipo_imposto" required>
                        <option value="" disabled selected>Selecione</option>
                        <option value="nenhum">Nenhum</option>
                        <option value="IPTU">IPTU - Imposto Predial e Territorial Urbano</option>
                        <option value="ITR">ITR - Imposto sobre a Propriedade Territorial Rural</option>
                    </select>
                </div>

                <div class="form-item">
                    <label for="valor_imposto">Valor do imposto:</label>
                    <input type="text" name="valor_imposto" id="valor_imposto">
                </div>

                <div class="form-item">
                    <label for="periodo_imposto">Periodicidade do Imposto:</label>
                    <select name="periodo_imposto" id="periodo_imposto" required>
                        <option value="" disabled selected>Selecione</option>
                        <option value="Nenhum">Nenhum</option>
                        <option value="Mensal">Mensal</option>
                        <option value="Anual">Anual</option>
                    </select>
                </div>

                <div class="form-item">
                    <label for="tamanho">Tamanho da propriedade: (m²)</label>
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
                <div class="form-item">
                    <label for="incra">N° INCRA</label>
                    <input type="text" name="incra" id="incra" maxlength="18" oninput="applyMask(this)">
                </div>
            </div>

            <button type="submit">Vincular Documentos</button>
            <a href="listar_propriedades.php">Voltar</a>
        </form>
    </section>
    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedade</p>
    </footer>

    <script>
        function applyMask(input) {
            let value = input.value.replace(/\D/g, ""); // Remove tudo que não é número
            value = value.replace(/(\d{3})(\d)/, "$1.$2"); // Coloca o primeiro ponto
            value = value.replace(/(\d{3})(\d)/, "$1.$2"); // Coloca o segundo ponto
            value = value.replace(/(\d{3})(\d)/, "$1.$2"); // Coloca o terceiro ponto
            value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2"); // Coloca o hífen
            input.value = value;
        }
    </script>

    <script>
        // Função para formatar valores como moeda com separador de milhar
        function formatCurrency(input) {
            // Remove todos os caracteres que não sejam números e vírgula
            let value = input.value.replace(/\D/g, "");

            // Converte para número inteiro e formata para duas casas decimais
            value = (value / 100).toFixed(2);

            // Substitui ponto por vírgula
            value = value.replace(".", ",");

            // Formata com separador de milhar
            let parts = value.split(",");

            // Formata a parte inteira com separadores de milhar
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            // Junta novamente a parte inteira com a parte decimal
            input.value = parts.join(",");
        }

        // Limpa a formatação de moeda antes de enviar o valor para o banco de dados
        function limparFormatacaoMoeda(input) {
            let valor = input.value;

            // Remove pontos de milhar e a vírgula decimal, convertendo para um número correto
            valor = valor.replace(/\./g, ""); // Remove os pontos
            valor = valor.replace(",", "."); // Substitui vírgula por ponto

            input.value = parseFloat(valor); // Altera o valor para um número
        }

        // Eventos para aplicar a formatação
        document.getElementById("valor_adquirido").addEventListener("input", function() {
            formatCurrency(this);
        });
        document.getElementById("valor_imposto").addEventListener("input", function() {
            formatCurrency(this);
        });

        // Limpar formatação antes de enviar
        document.querySelector("form").addEventListener("submit", function() {
            limparFormatacaoMoeda(document.getElementById("valor_adquirido"));
            limparFormatacaoMoeda(document.getElementById("valor_imposto"));
        });
    </script>
</body>

</html>