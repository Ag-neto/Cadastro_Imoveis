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
    <title>Criação de contrato</title>
    <link rel="stylesheet" href="../style/cadastrar_cidade.css">
</head>
<body>
    <header>
        <h1>Criação de contrato</h1>
    </header>

    <main>
        <section class="form-section">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $idpropriedade = $_POST['idpropriedade'];
                $idcliente = $_POST['idcliente'];
                $valor = $_POST['valor'];
                $data_ini = $_POST['data_inicio'];
                $data_fim = $_POST['data_fim'];
                $cobranca = $_POST['cobranca'];

                $tipo_contrato = "ALUGUEL";

                // Crie objetos DateTime para calcular o período de residência
                $data_inicio = new DateTime($data_ini);
                $data_final = new DateTime($data_fim);
                $diferenca = $data_inicio->diff($data_final);
                $periodo_residencia = $diferenca->days;

                // Insira o contrato
                $sql = "INSERT INTO contratos (id_propriedade, id_cliente, valor_aluguel, data_inicio_residencia, data_final_residencia, vencimento, periodo_residencia, tipo_contrato)
                        VALUES ('$idpropriedade', '$idcliente', '$valor', '$data_ini', '$data_fim', '$cobranca', '$periodo_residencia', '$tipo_contrato')";

                if (mysqli_query($conn, $sql)) {
                    $id_contrato = mysqli_insert_id($conn);

                    // Calcule as datas de vencimento dos pagamentos
                    $data_vencimento = new DateTime($data_ini);

                    while ($data_vencimento <= $data_final) {
                        // Insira cada pagamento com comprovante vazio e status 'pendente'
                        $sql_pagamento = "INSERT INTO pagamentos (id_contrato, valor, data_vencimento, status, comprovante)
                                          VALUES ('$id_contrato', '$valor', '{$data_vencimento->format('Y-m-d')}', 'pendente', '')";
                        mysqli_query($conn, $sql_pagamento);
                    
                        // Avance a data de vencimento para o próximo mês
                        $data_vencimento->modify('+1 month');
                    }
                        

                    header('Location: listar_contratos.php');
                } else {
                    echo "<p class='error'>Não foi possível gerar o contrato!</p>";
                }
            }
            ?>
        </section>

        <a href="../index.php" class="button">Voltar para o menu</a>
    </main>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>
</body>
</html>
