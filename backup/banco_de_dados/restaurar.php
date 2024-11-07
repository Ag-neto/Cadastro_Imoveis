<?php
session_start();
require_once "../../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../../usuario/login.php");
    exit;
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['backup_file'])) {
    $backupFile = $_FILES['backup_file']['tmp_name'];
    $backupFileName = $_FILES['backup_file']['name'];

    // Verifica se o arquivo é um .bat
    if (pathinfo($backupFileName, PATHINFO_EXTENSION) === 'bat') {
        // Move o arquivo para uma pasta temporária no servidor
        $targetFilePath = "../../backups/temp_restore.bat";
        if (move_uploaded_file($backupFile, $targetFilePath)) {
            // Executa o arquivo .bat para restaurar o backup
            $output = shell_exec("cmd /c $targetFilePath");

            // Exibe o resultado
            echo "Backup restaurado com sucesso!<br>";
            echo "<pre>" . htmlspecialchars($output) . "</pre>";

            // Remove o arquivo temporário após a execução
            unlink($targetFilePath);
        } else {
            echo "Erro ao mover o arquivo de backup.";
        }
    } else {
        echo "Por favor, selecione um arquivo .bat válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Restaurar Backup</title>
</head>
<body>
    <h2>Restaurar Backup</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="backup_file">Selecione o arquivo de backup (.bat):</label>
        <input type="file" name="backup_file" accept=".bat" required>
        <button type="submit">Restaurar Backup</button>
    </form>
</body>
</html>
