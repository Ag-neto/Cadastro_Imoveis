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
    $nome_propriedade = $_POST['nome_propriedade'];
    $endereco = $_POST['endereco'];
    $id_localizacao = $_POST['id_localizacao'];
    $valor_adquirido = $_POST['valor_adquirido'];
    $tamanho = $_POST['tamanho'];
    $id_situacao = $_POST['id_situacao'];
    $data = $_POST['data'];
    $id_tipo_prop = $_POST['id_tipo_prop'];

    $sql = "UPDATE propriedade SET nome_propriedade = '$nome_propriedade', endereco = '$endereco', id_localizacao = '$id_localizacao', valor_adquirido = '$valor_adquirido', tamanho = '$tamanho', id_situacao = '$id_situacao', data_registro = '$data', id_tipo_prop = '$id_tipo_prop' WHERE idpropriedade = '$id'";
    
    if (mysqli_query($conn, $sql)) {
        echo "$nome alterado com sucesso!";
        header('Location: detalhes_propriedade.php?id=' . $id);
    } else {
        echo "$nome não foi alterado!";
    }
    ?>

</body>

</html>
</body>

</html>