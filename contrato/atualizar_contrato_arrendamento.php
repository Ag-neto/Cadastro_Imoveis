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
    <title>Document</title>
</head>

<body>

    <!DOCTYPE html>
    <html lang="pt_br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>document</title>
    </head>

    <body>



        <?php
        $id = $_POST['id_contratos'];
        $id_propriedade = $_POST['id_propriedade'];
        $id_cliente = $_POST['id_cliente'];
        $valor = $_POST['valor'];
        $data_ini = $_POST['data_inicio'];
        $data_fim = $_POST['data_fim'];
        $vencimento = $_POST['vencimento'];

         // Crie objetos DateTime a partir das datas
         $data_inicio = new DateTime($data_ini);
         $data_final = new DateTime($data_fim);

         // Calcule a diferença entre as datas
         $diferenca = $data_inicio->diff($data_final);

         // Obtenha o número de dias da diferença
         $periodo_residencia = $diferenca->days;


        $sql = "UPDATE contratos SET id_propriedade = '$id_propriedade', id_cliente = '$id_cliente', valor = '$valor', data_inicio_residencia = '$data_ini', vencimento = '$vencimento', data_final_residencia = '$data_fim', periodo_residencia = '$periodo_residencia' WHERE id_contratos = '$id'";

        if (mysqli_query($conn, $sql)) {
            echo " alterado com sucesso!";
            header('Location: detalhes_contrato_aluguel.php?id=' . $id);
        } else {
            echo " não foi alterado!";
        }
        ?>

    </body>

    </html>
</body>

</html>
</body>

</html>