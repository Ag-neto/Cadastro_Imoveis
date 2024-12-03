<?php
// Exibir erros para debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../../usuario/login.php");
    exit;
}

if (isset($_POST['restore'])) {
    $uploadedFile = $_FILES['backup_file']['tmp_name'];

    if (!empty($uploadedFile) && is_uploaded_file($uploadedFile)) {
        // Define o caminho para salvar o arquivo enviado
        $targetDir = __DIR__ . "/uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $backupPath = $targetDir . "backup_restaurado.bat";

        if (move_uploaded_file($uploadedFile, $backupPath)) {
            chmod($backupPath, 0755);

            // Executa o comando para criar e restaurar o banco de dados
            $command = "cmd /c " . escapeshellarg($backupPath);
            exec($command . " 2>&1", $output, $returnCode);

            echo "<h3>Resultado do comando:</h3>";
            echo "Comando executado: $command<br>";
            echo "Código de retorno: $returnCode<br>";
            echo "Saída do comando:<br>" . implode("<br>", $output);

            if ($returnCode === 0) {
                echo "<p style='color: green;'>Banco de dados criado/restaurado com sucesso!</p>";
            } else {
                echo "<p style='color: red;'>Erro ao criar/restaurar o banco de dados. Verifique os detalhes acima.</p>";
            }
        } else {
            echo "<p style='color: red;'>Erro ao mover o arquivo de backup.</p>";
        }
    } else {
        echo "<p style='color: red;'>Nenhum arquivo de backup foi selecionado.</p>";
    }

    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar e Restaurar Banco</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 400px;
            text-align: center;
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Criar e Restaurar Banco</h2>
        <form method="post" action="criar_e_restaurar.php" enctype="multipart/form-data">
            <label for="backup_file">Selecione o arquivo de backup (.bat):</label>
            <input type="file" name="backup_file" accept=".bat" required>
            <button type="submit" name="restore">Criar e Restaurar</button>
            <a href="../../index.php">Voltar</a>
        </form>
    </div>
</body>
</html>
