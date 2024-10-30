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
    <title>Cadastro de Contrato de Venda</title>
    <link rel="stylesheet" href="../style/criar_contrato.css">
</head>

<body>
    <header>
        <h1>Cadastro de Contrato de Venda</h1>
    </header>

    <section class="form-section">
        <h2>Informações do Contrato</h2>
        <form id="contrato-venda-form" method="POST" action="contrato_venda_script.php">

            <!-- Escolha da propriedade -->
            <div class="form-group">
                <div class="form-item">
                    <label for="propriedade">Propriedade:</label>
                    <select id="propriedade" name="idpropriedade" required>
                        <option value="" disabled selected>Selecione a Propriedade</option>
                        <?php
                        // Consultar propriedades disponíveis para venda
                        $sql = "SELECT idpropriedade, nome_propriedade 
                                FROM propriedade 
                                JOIN situacao ON propriedade.id_situacao = situacao.id_situacao 
                                WHERE situacao.nome_situacao = 'À Venda'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['idpropriedade'] . '">' . $row['nome_propriedade'] . '</option>';
                            }
                        } else {
                            echo '<option value="">Nenhuma propriedade disponível para venda</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Escolha do comprador -->
            <div class="form-group">
                <div class="form-item">
                    <label for="comprador">Comprador:</label>
                    <select id="comprador" name="idcliente" required>
                        <option value="" disabled selected>Selecione o Comprador</option>
                        <?php
                        // Consultar clientes disponíveis
                        $sql = "SELECT idcliente, nome_cliente FROM cliente";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['idcliente'] . '">' . $row['nome_cliente'] . '</option>';
                            }
                        } else {
                            echo '<option value="">Nenhum cliente cadastrado</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Detalhes do contrato de venda -->
            <div class="form-group">
                <div class="form-item">
                    <label for="valor_venda">Valor Total de Venda (R$):</label>
                    <input type="number" id="valor_venda" name="valor_venda" placeholder="Ex: 350000" required>
                </div>

                <div class="form-item">
                    <label for="valor_entrada">Valor Entrada (R$):</label>
                    <input type="number" id="valor_entrada" name="valor_entrada" placeholder="Ex: 15000" required>
                </div>

                <div class="form-item">
                    <label for="data_conclusao">Data da compra:</label>
                    <input type="date" id="data_conclusao" name="data_conclusao" required>
                </div>
            </div>

            <!-- Botão para criar contrato -->
            <button type="submit">Criar Contrato</button>

            <!-- Botão para voltar à página anterior -->
            <a href="tipo_contrato.php">Voltar</a>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedade</p>
    </footer>
</body>

</html>
