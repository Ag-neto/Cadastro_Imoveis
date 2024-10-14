<?php
require_once "../conexao/conexao.php";

// Verifica se o ID do documento foi passado
if (isset($_GET['id'])) {
    $id_documento = intval($_GET['id']); // Converte para inteiro

    // Obtém o caminho do arquivo para exclusão
    $sql = "SELECT path FROM documentacao_propriedade WHERE iddocumentacao_propriedade = $id_documento";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $documento = mysqli_fetch_assoc($result);
        $caminho_arquivo = $documento['path'];

        // Remove o documento do banco de dados
        $sql_delete = "DELETE FROM documentacao_propriedade WHERE iddocumentacao_propriedade = $id_documento";
        if (mysqli_query($conn, $sql_delete)) {
            // Remove o arquivo do sistema de arquivos
            if (file_exists($caminho_arquivo)) {
                unlink($caminho_arquivo); // Deleta o arquivo
            }
            header("Location: detalhes_propriedade.php?id=" . $_GET['id_propriedade']);
            exit;
        } else {
            echo "Erro ao deletar o documento.";
        }
    } else {
        echo "Documento não encontrado.";
    }
} else {
    echo "ID do documento não fornecido.";
}
?>
