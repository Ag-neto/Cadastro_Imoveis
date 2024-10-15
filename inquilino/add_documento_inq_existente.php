<?php
require_once "../conexao/conexao.php";

$id = $_GET["idinquilino"] ?? "";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos</title>
    <link rel="stylesheet" href="../style/cadastro_propriedade_style.css">

</head>

<body>
<header>
        <h1>Documentação do Inquilino</h1>
    </header>
    <section class="form-section">
    <h2>Adicionar Documentação do Inquilino</h2>
    <form enctype="multipart/form-data" method="POST" action="add_doc_inq_existente_script.php">
        <label for="documentos">Insira as documentações do inquilino aqui:</label>
        <p><input multiple type="file" name="documentos[]" id="documentos"></p>
        <button type="submit">Salvar</button>
        <input type="hidden" name="idinquilino" value="<?php echo $id;?>">
    </form>
    </section>
</body>

</html>