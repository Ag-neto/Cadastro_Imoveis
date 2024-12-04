<?php
// Inclui o arquivo de configuração do banco de dados
require_once 'C:\xampp\htdocs\kargo\conexao\conexao.php';

// Defina o fuso horário correto
date_default_timezone_set('America/Sao_Paulo');

// Caminho para o executável mysqldump
$mysqlDumpPath = '"C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysqldump.exe"'; // Coloque o caminho entre aspas duplas

// Parâmetros para o mysqldump
$dbUser = 'root'; // Usuário do banco de dados
$dbPass = 'root'; // Senha do banco de dados
$dbName = 'kargo'; // Nome do banco de dados

// Diretório de destino para os backups
$backupDirectory = 'E:\\Kargo\\Backup\\backup'; // Alterar para o diretório desejado
$backupFile = $backupDirectory . 'backup_automático_' . date('d-m-Y_H-i-s') . '.sql'; // Nome do arquivo de backup

// Verifica se o diretório existe, caso contrário cria o diretório
if (!is_dir($backupDirectory)) {
    mkdir($backupDirectory, 0777, true);
}

// Comando mysqldump completo
$command = "$mysqlDumpPath -u $dbUser -p$dbPass $dbName > \"$backupFile\"";

// Executa o comando mysqldump
exec($command, $output, $return_var);

// Exibe a saída de erro e o código de retorno para depuração
if ($return_var === 0) {
    if (file_exists($backupFile)) {
        echo "Backup realizado com sucesso: $backupFile\n";
    } else {
        echo "Erro ao criar o backup: Arquivo de backup não encontrado.\n";
    }
} else {
    // Mensagem de erro sem log
    echo "Erro ao criar backup. O comando retornou o código: $return_var\n";
    echo "Saída do comando:\n" . implode("\n", $output) . "\n";
}
?>
