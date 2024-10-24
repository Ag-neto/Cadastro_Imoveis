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
    <title>Criação de contrato de Arrendamento</title>
    <link rel="stylesheet" href="../style/cadastrar_cidade.css">
</head>

<body>
    <header>
        <h1>Criação de contrato de Arrendamento</h1>
    </header>

    <main>
        <section class="form-section">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $idpropriedade = $_POST['idpropriedade'];
                $idarrendatario = $_POST['idarrendatario']; // Captura o ID do arrendatário
                $valor = $_POST['valor_arrendamento']; // Valor do arrendamento
                $data_ini = $_POST['data_inicio'];
                $data_fim = $_POST['data_termino'];
                $dia_cobranca = $_POST['dia_cobranca']; // Captura o dia de cobrança

                // Verifique se as variáveis necessárias não estão vazias
                if (!empty($idpropriedade) && !empty($idarrendatario) && !empty($valor) && !empty($data_ini) && !empty($data_fim) && !empty($dia_cobranca)) {
                    $tipo_contrato = "ARRENDAMENTO";

                    // Crie o SQL para inserção
                    $sql = "INSERT INTO contratos (id_propriedade, id_cliente, valor_aluguel, data_inicio_residencia, data_final_residencia, tipo_contrato, vencimento) 
                            VALUES ('$idpropriedade', '$idarrendatario', '$valor', '$data_ini', '$data_fim', '$tipo_contrato', '$dia_cobranca')";

                    if (mysqli_query($conn, $sql)) {
                        header('Location: listar_contratos.php');
                        exit(); // Para garantir que o script pare aqui
                    } else {
                        echo "<p class='error'>Não foi possível gerar o contrato! Erro: " . mysqli_error($conn) . "</p>";
                    }
                } else {
                    echo "<p class='error'>Por favor, preencha todos os campos obrigatórios!</p>";
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
