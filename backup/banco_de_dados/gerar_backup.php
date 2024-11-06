<?php
session_start();
require_once "../../conexao/conexao.php"; // Caminho ajustado para sair das pastas backup/banco_de_dados

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../../usuario/login.php");
    exit;
}

// Dados de conexão para o comando mysqldump
$database = 'controledepropriedade';
$user = 'root';
$password = '';
$host = 'localhost';

// Caminho completo para o mysqldump no XAMPP
$mysqldumpPath = "C:\\xampp\\mysql\\bin\\mysqldump.exe";

// Verifica se o arquivo mysqldump.exe existe no caminho especificado
if (!file_exists($mysqldumpPath)) {
    die("Erro: O caminho para o mysqldump está incorreto. Verifique a configuração.");
}

// Define o caminho completo do arquivo de backup
$backupDir = "../../backups";
$backupFile = "$backupDir/backup_" . date('Y-m-d_H-i-s') . ".sql";

// Verifica se a pasta de backup existe e tenta criá-la se não existir
if (!is_dir($backupDir)) {
    if (!mkdir($backupDir, 0777, true)) {
        die("Erro: Não foi possível criar a pasta de backups.");
    }
}

// Comando para gerar o backup e redirecionar erros
$command = "\"$mysqldumpPath\" --user=$user --password=$password --host=$host $database > \"$backupFile\" 2>&1";

// Executa o comando com shell_exec e captura a saída
$output = shell_exec($command);

// Verifica se o arquivo foi criado
if (file_exists($backupFile)) {
    echo "Backup realizado com sucesso! Arquivo gerado: $backupFile";
} else {
    echo "Erro ao gerar backup.<br>";
    echo "Saída do comando: <pre>" . htmlspecialchars($output) . "</pre>";
}
?>
