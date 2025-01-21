<?php
// Inclui o arquivo de configuração do banco de dados
require_once "../conexao/conexao.php";

// Defina o fuso horário correto
date_default_timezone_set('America/Sao_Paulo');

// Caminho para o executável mysqldump
$mysqlDumpPath = '"C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysqldump.exe"'; // Coloque o caminho entre aspas duplas

// Parâmetros para o mysqldump
$dbUser = 'root'; // Usuário do banco de dados
$dbPass = 'root'; // Senha do banco de dados
$dbName = 'controledepropriedade2'; // Nome do banco de dados
$backupFile = 'backup_' . date('d-m-Y_H-i-s') . '.sql'; // Nome do arquivo de backup
$errorLog = 'error_log.txt'; // Arquivo de log de erro

// Comando mysqldump completo
$command = "$mysqlDumpPath -u $dbUser -p$dbPass $dbName > $backupFile 2> $errorLog";

// Executa o comando mysqldump
exec($command, $output, $return_var);

// Exibe a saída de erro e o código de retorno para depuração
if ($return_var === 0) {
    if (file_exists($backupFile)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($backupFile));
        header('Content-Length: ' . filesize($backupFile));
        readfile($backupFile);

        // Remove o arquivo de backup após o download
        unlink($backupFile);
    } else {
        echo "Erro ao criar o backup: Arquivo de backup não encontrado.";
    }
} else {
    echo "Erro ao criar backup. Verifique o arquivo de log de erros: $errorLog";
    echo "<pre>" . file_get_contents($errorLog) . "</pre>";
}
?>



<?php 

                                            // AQUI É O CÓDIGO QUE FUNCIONA COM O LINUX



// Inclui o arquivo de configuração do banco de dados
//require_once "../conexao/conexao.php";

// Defina o fuso horário correto
//date_default_timezone_set('America/Sao_Paulo');

// Caminho para o executável mysqldump
//$mysqlDumpPath = '/usr/bin/mysqldump';

// Parâmetros para o mysqldump
//$dbUser = 'root'; // Usuário do banco de dados
//$dbPass = 'root'; // Senha do banco de dados
//$dbName = 'controledepropriedade2'; // Nome do banco de dados

// Caminho temporário no servidor para armazenar o backup
//$backupDir = '/tmp'; // Diretório temporário
//$backupFile = $backupDir . '/backup_' . date('d-m-Y_H-i-s') . '.sql';

// Comando mysqldump completo
//$command = "$mysqlDumpPath -u $dbUser -p$dbPass $dbName > $backupFile";

// Executa o comando mysqldump
//exec($command, $output, $return_var);

// Verifica se o backup foi criado com sucesso
//if ($return_var === 0) {
    //if (file_exists($backupFile)) {
        // Força o download do arquivo para o usuário escolher onde salvar
        //header('Content-Description: File Transfer');
        //header('Content-Type: application/octet-stream');
        //header('Content-Disposition: attachment; filename=' . basename($backupFile));
        //header('Content-Length: ' . filesize($backupFile));
        //readfile($backupFile);

        // Remove o arquivo de backup após o download
        //unlink($backupFile);
    //} else {
        //echo "Erro ao criar o backup: Arquivo de backup não encontrado.";
    //}
//} else {
    //echo "Erro ao criar backup. Verifique se o mysqldump está configurado corretamente.";
//}



?>
