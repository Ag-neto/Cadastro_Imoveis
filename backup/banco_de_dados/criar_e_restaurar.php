<?php
// Exibe erros para depuração
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

// Verifica se o caminho do arquivo foi passado
if (isset($_GET['file'])) {
    $backupPath = $_GET['file'];

    // Certifica-se de que o arquivo existe
    if (file_exists($backupPath)) {
        // Executa o comando do arquivo .bat
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
        echo "<p style='color: red;'>Arquivo de backup não encontrado.</p>";
    }
} else {
    echo "<p style='color: red;'>Nenhum arquivo de backup foi especificado.</p>";
}
?>
