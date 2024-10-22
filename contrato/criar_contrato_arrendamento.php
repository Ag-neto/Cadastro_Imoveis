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
        <form method="POST" action="processar_contrato_arrendamento.php"> <!-- Certifique-se que este arquivo exista -->
            <h2>Dados do Contrato de Arrendamento</h2>
            
            <div class="form-group">
                <div class="form-item">
                    <label for="propriedade">Propriedade:</label>
                    <select id="propriedade" name="propriedade" required>
                        <option value="" disabled selected>Selecione uma propriedade</option>
                        <?php
                        // Conexão com o banco de dados
                        require_once "../conexao/conexao.php";

                        // Selecionar propriedades disponíveis para Arrendamento
                        $sql = "SELECT p.idpropriedade, p.nome_propriedade 
                                FROM propriedade p 
                                JOIN situacao s ON p.id_situacao = s.id_situacao
                                WHERE s.nome_situacao = 'Arrendamento'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['idpropriedade'] . '">' . $row['nome_propriedade'] . '</option>';
                            }
                        } else {
                            echo '<option value="">Nenhuma propriedade disponível para arrendamento</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-item">
                    <label for="arrendatario">Arrendatário:</label>
                    <input type="text" id="arrendatario" name="arrendatario" required placeholder="Digite o nome do arrendatário">
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
            </div>

            <button type="submit">Criar Contrato</button>
            <a href="listar_contratos.php" class="btn-voltar">Voltar</a> <!-- Certifique-se que listar_contratos.php exista -->
        </form>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedade</p>
    </footer>
</body>

</html>
