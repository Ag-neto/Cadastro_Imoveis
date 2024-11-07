<?php
session_start();
require_once "../../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../../usuario/login.php");
    exit;
}

// Dados de conexão
$database = 'controledepropriedade';
$user = 'root';
$password = '';
$host = 'localhost';
$mysqldumpPath = "C:\\xampp\\mysql\\bin\\mysqldump.exe";

if (!file_exists($mysqldumpPath)) {
    die("Erro: Caminho do mysqldump incorreto.");
}

$backupDir = "../../backups";
$backupFile = "backup_" . date('Y-m-d_H-i-s') . ".sql";
$backupFilePath = "$backupDir/$backupFile";
$batFilePath = "$backupDir/fazer_backup.bat";

if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
}

$batContent = <<<EOD
@echo off
"$mysqldumpPath" --user=$user --password=$password --host=$host $database > "$backupFilePath"
exit
EOD;

file_put_contents($batFilePath, $batContent);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="fazer_backup.bat"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($batFilePath));
readfile($batFilePath);
unlink($batFilePath);
exit;
?>
