<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../../usuario/login.php");
    exit;
}

if (isset($_POST['restore'])) {
    if (!empty($_FILES['backup_file']['tmp_name']) && is_uploaded_file($_FILES['backup_file']['tmp_name'])) {
        $backupPath = __DIR__ . "/backup_restaurado.bat";

        if (move_uploaded_file($_FILES['backup_file']['tmp_name'], $backupPath)) {
            $conn = new mysqli($server, $user, $password);

            if ($conn->connect_error) {
                die("Erro ao conectar ao MySQL: " . $conn->connect_error);
            }

            $sql = "CREATE DATABASE IF NOT EXISTS `$bd`";
            if ($conn->query($sql) === TRUE) {
                $conn->close();

                chmod($backupPath, 0755);
                $command = "cmd /c " . escapeshellarg($backupPath);
                exec($command, $output, $returnVar);

                if ($returnVar === 0) {
                    echo "Banco de dados criado e backup restaurado com sucesso!";
                } else {
                    echo "Erro ao restaurar o backup. Código de retorno: $returnVar<br>Saída:<br>" . implode("<br>", $output);
                }
            } else {
                echo "Erro ao criar o banco de dados: " . $conn->error;
            }
        } else {
            echo "Erro ao mover o arquivo de backup.";
        }
    } else {
        echo "Nenhum arquivo de backup foi selecionado.";
    }

    exit; // Remove o redirecionamento temporário para debug
}
?>
