<?php
require_once "../conexao/conexao.php";

// Verifica se o ID do documento foi passado
if (isset($_GET['id'])) {
    $id_documento = intval($_GET['id']);

    // Obtém os detalhes do documento
    $sql = "SELECT * FROM documentacao_propriedade WHERE iddocumentacao_propriedade = $id_documento";
    $result = mysqli_query($conn, $sql);
    $documento = mysqli_fetch_assoc($result);
} else {
    echo "ID do documento não fornecido.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se um novo arquivo foi enviado
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == UPLOAD_ERR_OK) {
        $arquivo = $_FILES['arquivo'];
        $error = $arquivo['error'];
        $size = $arquivo['size'];
        $name = $arquivo['name'];
        $tmp_name = $arquivo['tmp_name'];

        if ($error) {
            echo "<p>Erro ao enviar o arquivo.</p>";
        } elseif ($size > 2097152) {
            echo "<p>Arquivo muito grande.</p>";
        } else {
            $pasta = "arquivos/";
            $novo_nome_arquivo = uniqid();
            $extensao = strtolower(pathinfo($name, PATHINFO_EXTENSION));

            if ($extensao != "pdf") {
                echo "<p>Tipo de arquivo não suportado. Apenas PDFs são permitidos.</p>";
            } else {
                $caminho_completo = $pasta . $novo_nome_arquivo . "." . $extensao;

                if (move_uploaded_file($tmp_name, $caminho_completo)) {
                    // Atualiza o registro no banco de dados
                    $sql = "UPDATE documentacao_propriedade SET nome_doc = '$name', path = '$caminho_completo', data_upload = NOW() WHERE iddocumentacao_propriedade = $id_documento";

                    if (mysqli_query($conn, $sql)) {
                        echo "<p>Documento atualizado com sucesso!</p>";
                    } else {
                        echo "<p>Erro ao atualizar o documento: " . mysqli_error($conn) . "</p>";
                    }
                } else {
                    echo "<p>Falha ao mover o arquivo.</p>";
                }
            }
        }
    } else {
        echo "<p>Nenhum novo arquivo enviado.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Documento</title>
</head>
<body>
    <h1>Editar Documento</h1>
    <form action="editar_documento.php?id=<?php echo $id_documento; ?>" method="POST" enctype="multipart/form-data">
        <label for="nome_doc">Nome do Documento:</label>
        <input type="text" name="nome_doc" value="<?php echo htmlspecialchars($documento['nome_doc']); ?>" required>

        <label for="arquivo">Novo Arquivo:</label>
        <input type="file" name="arquivo">

        <button type="submit">Salvar Alterações</button>
    </form>
    <a href="detalhes_propriedade.php?id=<?php echo $_GET['id_propriedade']; ?>">Voltar</a>
</body>
</html>
