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
        $data_compra = $_POST['data_compra'];

         // Crie objetos DateTime a partir das datas
         $data_inicio = new DateTime($data_ini);
         $data_final = new DateTime($data_fim);

         // Calcule a diferença entre as datas
         $diferenca = $data_inicio->diff($data_final);

         // Obtenha o número de dias da diferença
         $periodo_residencia = $diferenca->days;


        $sql = "UPDATE contratos SET id_propriedade = '$id_propriedade', id_cliente = '$id_cliente', valor = '$valor', data_compra = '$data_compra' WHERE id_contratos = '$id'";

        if (mysqli_query($conn, $sql)) {
            echo " alterado com sucesso!";
            header('Location: detalhes_contrato_venda.php?id=' . $id);
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