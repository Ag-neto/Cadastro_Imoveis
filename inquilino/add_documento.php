<?php
require_once "../conexao/conexao.php";
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
        <h1>Cadastro de inquilino</h1>
    </header>
    <section class="form-section">
        <h2>Adicionar Documentação do inquilino</h2>
        <form enctype="multipart/form-data" method="POST" action="add_documento_inq.php">
            <label for="documentos">Anexe os documentos (CPF e RG) em formato PDF:</label>
            <p><input multiple type="file" name="documentos[]" id="documentos"></p>
            <button type="submit">Salvar</button>
        </form>
    </section>
</body>

</html>