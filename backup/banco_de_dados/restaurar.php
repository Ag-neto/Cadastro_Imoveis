<?php
session_start();
require_once "../../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../../usuario/login.php");
    exit;
}

if (isset($_POST['restore'])) {
    // Defina os detalhes do banco de dados
    $database = $bd;
    $user = $user;
    $password = $password;
    $host = $server;

    // Arquivo de backup escolhido pelo usuário
    $backupFile = $_FILES['backup_file']['tmp_name'];

    // Verifica se um arquivo foi enviado
    if (is_uploaded_file($backupFile)) {
        // Comando para restaurar o backup
        $command = "mysql --user=$user --password=$password --host=$host $database < $backupFile";
        system($command, $output);

        if ($output === 0) {
            echo "Backup restaurado com sucesso!";
        } else {
            echo "Erro ao restaurar o backup.";
        }
    } else {
        echo "Nenhum arquivo de backup foi selecionado.";
    }

    // Redireciona para a página inicial após a restauração
    header("Location: ../../index.php");
    exit;
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
    <form method="post" action="restaurar.php" enctype="multipart/form-data">
        <label for="backup_file">Selecione o arquivo de backup (.bat):</label>
        <input type="file" name="backup_file" accept=".bat">
        <button type="submit" name="restore">Restaurar Backup</button>
    </form>
</body>
</html>
