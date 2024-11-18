<?php
session_start();
require_once "../../conexao/conexao.php";

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
$mysqldumpPath = "C:\\Program Files\\MySQL\\MySQL Server 8.0\bin\\mysqldump.exe";

// Verifica se o arquivo mysqldump.exe existe no caminho especificado
if (!file_exists($mysqldumpPath)) {
    die("Erro: O caminho para o mysqldump está incorreto. Verifique a configuração.");
}

// Define o caminho completo do arquivo de backup
$backupDir = "../../backups";
$backupFilePath = "$backupDir/backup.bat"; // Define o nome do arquivo como "backup.bat"

// Verifica se a pasta de backup existe e tenta criá-la se não existir
if (!is_dir($backupDir)) {
    if (!mkdir($backupDir, 0777, true)) {
        die("Erro: Não foi possível criar a pasta de backups.");
    }
}

// Conteúdo do arquivo .bat para fazer o backup
$batContent = <<<EOD
@echo off
"$mysqldumpPath" --user=$user --password=$password --host=$host $database > "$backupDir/backup_" . date('Y-m-d_H-i-s') . ".sql"
exit
EOD;

// Cria o arquivo .bat com o conteúdo definido
file_put_contents($backupFilePath, $batContent);

// Define os cabeçalhos para download do arquivo .bat
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="backup.bat"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($backupFilePath));
readfile($backupFilePath);

// Remove o arquivo temporário após o download
unlink($backupFilePath);
exit;
?>
