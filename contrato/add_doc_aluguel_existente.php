<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}
?>

<?php
$id = $_GET["id_contrato"] ?? "";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos</title>
    <link rel="stylesheet" href="../style/style_add_contrato_pdf.css">

</head>

<body>
    <section class="form-section">
    <h2>Adicionar Contrato em PDF</h2>
    <form enctype="multipart/form-data" method="POST" action="add_doc_aluguel_existente_script.php">
        <label for="documentos">Insira o contrato aqui:</label>
        <p><input multiple type="file" name="documentos[]" id="documentos"></p>
        <button type="submit">Salvar</button>
        <input type="hidden" name="id_contrato" value="<?php echo $id;?>">
    </form>
    <a href="detalhes_contrato_aluguel.php">Voltar</a>
    </section>
</body>

</html>