<?php
require_once "../conexao/conexao.php";
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
                $idinquilino = $_POST['idinquilino'];
                $valor = $_POST['valor'];
                $data_ini = $_POST['data_inicio'];
                $data_fim = $_POST['data_fim'];
                $cobranca = $_POST['cobranca'];

                $tipo_contrato = "ARRENDAMENTO";

                // Crie objetos DateTime a partir das datas
                $data_inicio = new DateTime($data_ini);
                $data_final = new DateTime($data_fim);

                // Calcule a diferença entre as datas
                $diferenca = $data_inicio->diff($data_final);

                // Obtenha o número de dias da diferença
                $periodo_residencia = $diferenca->days;

                // Inserir no banco de dados o contrato de arrendamento
                $sql = "INSERT INTO contratos (id_propriedade, id_inquilino, valor_aluguel, data_inicio_residencia, data_final_residencia, vencimento, periodo_residencia, tipo_contrato) 
                        VALUES ('$idpropriedade', '$idinquilino', '$valor', '$data_ini', '$data_fim', '$cobranca', '$periodo_residencia', '$tipo_contrato')";

                // Verifica se o contrato foi inserido com sucesso
                if (mysqli_query($conn, $sql)) {
                    // Redireciona para a página de listagem de contratos
                    header('Location: listar_contratos.php');
                    exit();  // Garante que o script seja finalizado após o redirecionamento
                } else {
                    echo "<p class='error'>Não foi possível gerar o contrato de arrendamento!</p>";
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
