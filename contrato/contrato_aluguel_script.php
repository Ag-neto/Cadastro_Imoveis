<?php
require_once "../conexao/conexao.php";
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
                $idinquilino = $_POST['idinquilino'];
                $valor = $_POST['valor'];
                $data_ini = $_POST['data_inicio'];
                $data_fim = $_POST['data_fim'];
                $cobranca = $_POST['cobranca'];

                $tipo_contrato = "ALUGUEL";

                // Crie objetos DateTime a partir das datas
                $data_inicio = new DateTime($data_ini);
                $data_final = new DateTime($data_fim);

                // Calcule a diferença entre as datas
                $diferenca = $data_inicio->diff($data_final);

                // Obtenha o número de dias da diferença
                $periodo_residencia = $diferenca->days;


                $sql = "INSERT INTO contratos (id_propriedade, id_inquilino, valor_aluguel, data_inicio_residencia, data_final_residencia, vencimento, periodo_residencia, tipo_contrato) VALUES ('$idpropriedade', '$idinquilino', '$valor', '$data_ini', '$data_fim', '$cobranca', '$periodo_residencia', '$tipo_contrato')";

                if (mysqli_query($conn, $sql)) {
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