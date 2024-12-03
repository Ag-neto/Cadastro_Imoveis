<?php
// Habilita a exibição de erros para depuração
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

            // Testa o caminho para o MySQL antes de executar
            $testCommand = "mysql --version";
            exec($testCommand, $mysqlOutput, $mysqlReturnCode);

            if ($mysqlReturnCode !== 0) {
                echo "<p style='color: red;'>Erro: O comando 'mysql' não está acessível no sistema. Verifique se o MySQL está instalado e configurado corretamente no PATH.</p>";
                echo "<p>Saída do teste: " . implode("<br>", $mysqlOutput) . "</p>";
                exit;
            }

            // Executa o comando para restaurar o backup
            $command = "cmd /c " . escapeshellarg($backupPath);
            exec($command, $output, $returnCode);

            echo "<h3>Resultado do comando:</h3>";
            echo "Comando executado: $command<br>";
            echo "Código de retorno: $returnCode<br>";
            echo "Saída do comando:<br>" . implode("<br>", $output);

            if ($returnCode === 0) {
                echo "<p style='color: green;'>Backup restaurado com sucesso!</p>";
            } else {
                echo "<p style='color: red;'>Erro ao restaurar o backup. Verifique os detalhes acima.</p>";
            }
        } else {
            echo "<p style='color: red;'>Erro ao mover o arquivo de backup.</p>";
        }
    } else {
        echo "<p style='color: red;'>Nenhum arquivo de backup foi selecionado.</p>";
    }

    exit; // Remove o redirecionamento temporário para debug
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
        <h2>Restaurar Backup</h2>
        <form method="post" action="restaurar.php" enctype="multipart/form-data">
            <label for="backup_file">Selecione o arquivo de backup (.bat):</label>
            <input type="file" name="backup_file" accept=".bat" required>
            <button type="submit" name="restore">Restaurar Backup</button>
            <a href="../../index.php">Voltar</a>
        </form>
    </div>
</body>
</html>
