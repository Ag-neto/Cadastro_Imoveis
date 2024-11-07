<?php
session_start();
require_once "../../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../../usuario/login.php");
    exit;
}

if (isset($_POST['restore'])) {
    $database = $bd;
    $user = $user;
    $password = $password;
    $host = $server;
    $backupFile = $_POST['backup_file'];
    $command = "mysql --user=$user --password=$password --host=$host $database < ../../backups/$backupFile";
    system($command, $output);

    if ($output === 0) {
        echo "Backup restaurado com sucesso!";
    } else {
        echo "Erro ao restaurar o backup.";
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
    <form method="post" action="restaurar.php">
        <label for="backup_file">Selecione o arquivo de backup:</label>
        <select name="backup_file">
            <?php
            $files = scandir('../../backups');
            foreach ($files as $file) {
                if (strpos($file, '.sql') !== false) {
                    echo "<option value=\"$file\">$file</option>";
                }
            }
            ?>
        </select>
        <button type="submit" name="restore">Restaurar Backup</button>
    </form>
</body>
</html>
