<?php
require_once "../conexao/conexao.php";
?>

<!DOCTYPE html>
<html lang="pt_br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>document</title>
</head>

<body>



    <?php
    $id = $_POST['id'];
    $nome = $_POST['nome_inquilino'];
    $endereco = $_POST['endereco'];
    $localidade = intval($_POST['id_localizacao']);
    $data_nascimento = $_POST['data_nascimento'];
    $rg_numero = $_POST['rg_numero'];
    $cpf_numero = $_POST['cpf_numero'];
    $telefone = $_POST['telefone'];

    $sql = "UPDATE inquilino SET nome_inquilino = '$nome', endereco = '$endereco', id_localizacao = '$localidade', data_nascimento = '$data_nascimento', rg_numero = '$rg_numero', cpf_numero = '$cpf_numero', telefone = '$telefone' WHERE idinquilino = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "$nome alterado com sucesso!";
        header('Location: detalhes_inquilino.php?id=' . $id);
    } else {
        echo "$nome não foi alterado!";
    }
    ?>

</body>

</html>
</body>

</html>