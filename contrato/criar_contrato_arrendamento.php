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
    <title>Criar Contrato de Arrendamento</title>
    <link rel="stylesheet" href="../style/criar_contrato.css"> <!-- Caminho relativo ajustado -->
</head>

<body>
    <header>
        <h1>Criar Contrato de Arrendamento</h1>
    </header>

    <section class="form-section">
        <form method="POST" action="contrato_arrendamento_script.php"> <!-- Certifique-se que este arquivo exista -->
            <h2>Dados do Contrato de Arrendamento</h2>
            
            <div class="form-group">
                <div class="form-item">
                    <label for="propriedade">Propriedade:</label>
                    <select id="propriedade" name="idpropriedade" required>
                        <option value="" disabled selected>Selecione uma propriedade</option>
                        <?php
                        // Conexão com o banco de dados
                        require_once "../conexao/conexao.php";

                        // Selecionar propriedades disponíveis para Arrendamento
                        $sql = "SELECT p.idpropriedade, p.nome_propriedade 
                                FROM propriedade p 
                                JOIN situacao s ON p.id_situacao = s.id_situacao
                                WHERE s.nome_situacao = 'ARRENDAMENTO' 
                                AND p.idpropriedade NOT IN (SELECT c.id_propriedade FROM contratos c)";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['idpropriedade'] . '">' . $row['nome_propriedade'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="form-item">
                    <label for="arrendatario">Arrendatário:</label>
                    <select id="arrendatario" name="idarrendatario" required>
                        <option value="" disabled selected>Selecione um arrendatário</option>
                        <?php
                        // Selecionar arrendatários disponíveis
                        $sql = "SELECT idcliente, nome_cliente FROM cliente"; // Ajuste a tabela de acordo com sua estrutura
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['idcliente'] . '">' . $row['nome_cliente'] . '</option>';
                            }
                        } else {
                            echo '<option value="">Nenhum arrendatário disponível</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="form-item">
                    <label for="data_inicio">Data de Início:</label>
                    <input type="date" id="data_inicio" name="data_inicio" required>
                </div>

                <div class="form-item">
                    <label for="data_termino">Data de Término:</label>
                    <input type="date" id="data_termino" name="data_termino" required>
                </div>
            </div>

            <div class="form-group">
                <div class="form-item">
                    <label for="valor_arrendamento">Valor do Arrendamento (R$):</label>
                    <input type="number" id="valor_arrendamento" name="valor_arrendamento" required placeholder="Digite o valor do arrendamento" step="0.01">
                </div>
                
                <div class="form-item">
                    <label for="dia_cobranca">Dia de Cobrança:</label>
                    <input type="date" id="dia_cobranca" name="dia_cobranca" required>
                </div>
            </div>

            <button type="submit">Criar Contrato</button>
            <a href="tipo_contrato.php" class="btn-voltar">Voltar</a>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedade</p>
    </footer>
</body>

</html>
