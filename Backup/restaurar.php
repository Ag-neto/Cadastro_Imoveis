<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KARGO</title>
    <link rel="stylesheet" href="style/style_index.css">
    <link rel="shortcut icon" href="../imagens/balanca.ico" type="image/x-icon">
</head>

<body>
    <div class="menu">

        <form action="restaurar_backup.php" method="post" enctype="multipart/form-data">
            <h1>Restaurar Backup do Banco de Dados</h1>
            <label for="file">Selecione o arquivo:</label>
            <input type="file" name="file" id="file"><br>
            <label for="nomeBanco">Nome do novo banco de dados:</label>
            <input type="text" name="nomeBanco" id="nomeBanco" value="controledepropriedade2" Readonly ><br><br>
            <button type="submit" name="submit">Restaurar</button>
        </form>
        
    </div>