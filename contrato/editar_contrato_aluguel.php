<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}
?>

<?php

$id = $_GET["id"] ?? "";

$sql = "SELECT * FROM contratos WHERE id_contratos = $id";

$dados = mysqli_query($conn, $sql);

$linha = mysqli_fetch_assoc($dados);

$data_inicial = isset($linha['data_inicio_residencia']) ? date('Y-m-d', strtotime($linha['data_inicio_residencia'])) : '';
$data_final = isset($linha['data_final_residencia']) ? date('Y-m-d', strtotime($linha['data_final_residencia'])) : '';
$vencimento = isset($linha['vencimento']) ? date('Y-m-d', strtotime($linha['vencimento'])) : '';
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contrato</title>
    <link rel="stylesheet" href="../style/editar_contrato.css">
</head>

<body>
    <header>
        <h1>Editar Contrato</h1>
    </header>

    <section class="form-section">
        <h2>Informações do Contrato</h2>
        <form action="atualizar_contrato_aluguel.php" method="POST">

            <!-- ID do contrato (oculto) -->
            <input type="hidden" id="id_contratos" name="id_contratos" value="<?php echo $id ?>"> <!-- Substitua pelo ID real -->

            <!-- Escolha da propriedade -->
            <div class="form-group">
                <div class="form-item">
                    <label for="propriedade">Propriedade:</label>
                    <select id="id_propriedade" name="id_propriedade" required>
                        <?php
                        // Consulta para buscar todas as propriedades
                        $sql = "SELECT p.idpropriedade, p.nome_propriedade 
                                FROM propriedade p";

                        // Executa a consulta
                        $result = $conn->query($sql);

                        // Loop pelos resultados
                        while ($row = $result->fetch_assoc()) {
                            // Verifica se o id_propriedade corresponde ao do contrato (se aplicável)
                            $selected = isset($linha['id_propriedade']) && $row['idpropriedade'] == $linha['id_propriedade'] ? 'selected' : '';
                            echo '<option value="' . $row['idpropriedade'] . '" ' . $selected . '>' . htmlspecialchars($row['nome_propriedade']) . '</option>';
                        }

                        ?>
                    </select>

                </div>
            </div>

            <!-- Escolha do cliente -->
            <div class="form-group">
                <div class="form-item">
                    <label for="id_cliente">Cliente:</label>
                    <select id="id_cliente" name="id_cliente" required>
                        <?php
                        // Consulta para buscar todas as propriedades
                        $sql = "SELECT i.idcliente, i.nome_cliente 
                                FROM cliente i";

                        // Executa a consulta
                        $result = $conn->query($sql);

                        // Loop pelos resultados
                        while ($row = $result->fetch_assoc()) {
                            // Verifica se o id_cliente corresponde ao do contrato (se aplicável)
                            $selected = isset($linha['id_cliente']) && $row['idcliente'] == $linha['id_cliente'] ? 'selected' : '';
                            echo '<option value="' . $row['idcliente'] . '" ' . $selected . '>' . htmlspecialchars($row['nome_cliente']) . '</option>';
                        }

                        ?>
                    </select>
                </div>
            </div>

            <!-- Detalhes do contrato -->
            <div class="form-group">
                <div class="form-item">
                    <label for="valor">Valor (R$):</label>
                    <input type="number" id="valor" name="valor" value="<?php echo $linha['valor']; ?>">
                </div>

                <div class="form-item">
                    <label for="data_inicio">Data Inicial:</label>
                    <input type="date" name="data_inicio" id="data_inicio" value="<?php echo $data_inicial; ?>">
                </div>

                <div class="form-item">
                    <label for="data_fim">Data Final:</label>
                    <input type="date" name="data_fim" id="data_fim" value="<?php echo $data_final; ?>">
                </div>

                <div class="form-item">
                    <label for="vencimento">Vencimento:</label>
                    <input type="date" name="vencimento" id="vencimento" value="<?php echo $vencimento ?>">
                </div>
            </div>

            <!-- Botão para atualizar contrato -->
            <button type="submit">Salvar</button>

            <a href="detalhes_contrato_aluguel.php?id=<?php echo $linha['id_contratos']; ?>">Voltar</a>

        </form>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>
</body>

</html>