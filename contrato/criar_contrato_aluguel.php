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

                        // Consulta apenas propriedades com situação 'Para Alugar' que não estão vinculadas a contratos
                        $sql = "SELECT p.idpropriedade, p.nome_propriedade
                                FROM propriedade p
                                JOIN situacao s ON p.id_situacao = s.id_situacao
                                WHERE s.nome_situacao = 'Para Alugar' 
                                AND p.idpropriedade NOT IN (SELECT c.id_propriedade FROM contratos c)";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['idpropriedade'] . '">' . $row['nome_propriedade'] . '</option>';
                            }
                        } else {
                            echo '<option value="">Nenhuma propriedade disponível para aluguel</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>


            <!-- Escolha do cliente -->
            <div class="form-group">
                <div class="form-item">
                    <label for="cliente">Cliente:</label>
                    <select name="idcliente" id="idcliente" required>
                        <option value="" disabled selected>Selecione</option>
                        <?php
                        $sql = "SELECT * FROM cliente";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['idcliente'] . '">' . $row['nome_cliente'] . '</option>';
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
                    <label for="cobranca">Cobrança:</label>
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