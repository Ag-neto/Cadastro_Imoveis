<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Contrato de Aluguel</title>
    <link rel="stylesheet" href="../style/criar_contrato.css">
</head>

<body>
    <header>
        <h1>Cadastro de Contrato de Aluguel</h1>
    </header>

    <section class="form-section">
        <h2>Informações do Contrato</h2>
        <form id="contrato-form" method="POST" action="contrato_aluguel_script.php"> 

            <!-- Escolha da propriedade -->
            <div class="form-group">
                <div class="form-item">
                    <label for="propriedade">Propriedade:</label>
                    <select name="idpropriedade" id="idpropriedade" required>
                        <option value="" disabled selected>Selecione</option>
                        <?php
                        require_once "../conexao/conexao.php";

                        $sql = "SELECT * FROM propriedade";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['idpropriedade'] . '">' . $row['nome_propriedade'] . '</option>';
                            }
                        }

                        ?>
                    </select>
                </div>
            </div>

            <!-- Escolha do inquilino -->
            <div class="form-group">
                <div class="form-item">
                    <label for="inquilino">Inquilino:</label>
                    <select name="idinquilino" id="idinquilino" required>
                        <option value="" disabled selected>Selecione</option>
                        <?php

                        $sql = "SELECT * FROM inquilino";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['idinquilino'] . '">' . $row['nome_inquilino'] . '</option>';
                            }
                        }

                        ?>
                    </select>
                </div>
            </div>

            <!-- Detalhes do contrato -->
            <div class="form-group">
                <div class="form-item">
                    <label for="valor">Valor do Aluguel (R$):</label>
                    <input type="number" id="valor" name="valor" placeholder="Ex: 1200" required>
                </div>

                <div class="form-item">
                    <label for="data_inicio">Data de Início:</label>
                    <input type="date" id="data_inicio" name="data_inicio" required>
                </div>

                <div class="form-item">
                    <label for="data_fim">Data de Término:</label>
                    <input type="date" id="data_fim" name="data_fim" required>
                </div>
                <div class="form-item">
                    <label for="cobranca">Cobrança</label>
                    <input type="date" id="cobranca" name="cobranca" required>
                </div>
            </div>

            <!-- Botão para criar contrato -->
            <button type="submit">Criar Contrato</button>

            <a href="tipo_contrato.php">Voltar</a>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedade</p>
    </footer>
</body>

</html>