<?php
// Inclui o arquivo de configuração do banco de dados
require_once "../../conexao/conexao.php";

// Defina o fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Caminho para o executável mysqldump
$mysqlDumpPath = '"C:\\xampp\\mysql\\bin\\mysqldump.exe"';

// Caminho para o mysql
$mysqlPath = '"C:\\xampp\\mysql\\bin\\mysql.exe"';

// Validação do caminho do mysqldump
if (!file_exists(str_replace('"', '', $mysqlDumpPath))) {
    die("Erro: Caminho para mysqldump está incorreto.");
}

// Parâmetros para o mysqldump
$dbUser = 'root';
$dbPass = 'gui13579';
$dbHost = 'localhost';
$dbName = 'controledepropriedade2';

// Diretório e nome do backup
$backupDir = "../../backups";
$backupSQLFile = "$backupDir/backup.sql";
$backupBATFile = "$backupDir/backup.bat";

// Criação do diretório de backup, se necessário
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
}

// Gera o backup .sql completo (estrutura e dados)
$sqlDumpCommand = <<<COMMAND
$mysqlDumpPath --user=$dbUser --password=$dbPass --host=$dbHost --routines --triggers --databases $dbName > "$backupSQLFile"
COMMAND;
exec($sqlDumpCommand, $output, $returnCode);

if ($returnCode !== 0) {
    die("Erro ao gerar o arquivo SQL. Verifique o mysqldump.");
}

// Conteúdo do arquivo .bat para restauração
$batContent = <<<BAT
@echo off
$mysqlPath --user=$dbUser --password=$dbPass --host=$dbHost -e "CREATE DATABASE IF NOT EXISTS $dbName;"
$mysqlPath --user=$dbUser --password=$dbPass --host=$dbHost $dbName < "$backupSQLFile"
IF ERRORLEVEL 1 (
    echo Erro ao restaurar o backup.
    exit /b
)
echo Backup gerado e configurado com sucesso!
exit
BAT;

// Salva o arquivo .bat
file_put_contents($backupBATFile, $batContent);

// Envia o arquivo para download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="backup.bat"');
readfile($backupBATFile);

// Remove o arquivo temporário após envio
unlink($backupBATFile);
exit;
?>
