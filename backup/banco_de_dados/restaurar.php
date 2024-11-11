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

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        .container {
            background-color: #fff;
            padding: 20px 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 400px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }

        input[type="file"] {
            margin: 10px 0 20px;
            padding: 8px;
            font-size: 14px;
            cursor: pointer;
        }

        button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        a{
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        a:hover {
            background-color: #45a049;
        }
    </style>

</head>
<body>
    <h2>Restaurar Backup</h2>
    <form method="post" action="restaurar.php" enctype="multipart/form-data">
        <label for="backup_file">Selecione o arquivo de backup (.bat):</label>
        <input type="file" name="backup_file" accept=".bat">
        <button type="submit" name="restore">Restaurar Backup</button>
        <a href="../../index.php">Voltar</a>
    </form>
</body>
</html>
