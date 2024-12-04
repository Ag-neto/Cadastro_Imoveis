<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurar Banco</title>
</head>
<body>
<?php
// Configurações do banco de dados
$server = "localhost";
$user = "root";
$password = "root";
$bd = "controledepropriedade2";

// Tentativa de conexão com o banco de dados
$conn = new mysqli($server, $user, $password);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifica se o banco de dados existe
$result = $conn->query("SHOW DATABASES LIKE '$bd'");

if ($result->num_rows == 0) {
    // O banco de dados não existe, tenta criar
    $create_db_query = "CREATE DATABASE $bd";
    if ($conn->query($create_db_query) === TRUE) {
        echo "Banco de dados '$bd' criado com sucesso.<br>";
    } else {
        die("Erro ao criar o banco de dados '$bd': " . $conn->error);
    }
}

// Conecta ao banco de dados principal
$conn = new mysqli($server, $user, $password, $bd);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados '$bd': " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    // Verifica se um arquivo foi enviado
    if ($_FILES["file"]["error"] == UPLOAD_ERR_OK && is_uploaded_file($_FILES["file"]["tmp_name"])) {

        // Configurações
        $diretorio_destino = "uploads/";  // Diretório onde o arquivo será armazenado temporariamente
        $arquivo_temporario = $_FILES["file"]["tmp_name"];
        $nome_arquivo = $_FILES["file"]["name"];
        $nome_novo_banco = $_POST["nomeBanco"];

        // Verifica se o diretório de destino existe e é gravável
        if (!is_dir($diretorio_destino) || !is_writable($diretorio_destino)) {
            die("Erro: Diretório de destino não existe ou não tem permissões de escrita.");
        }

        // Move o arquivo para o diretório temporário
        if (move_uploaded_file($arquivo_temporario, $diretorio_destino . $nome_arquivo)) {

            // Criação ou verificação do banco de dados
            $query_criar_bd = "CREATE DATABASE IF NOT EXISTS $nome_novo_banco";
            if ($conn->query($query_criar_bd) === TRUE) {

                // Conexão com o novo banco de dados
                $conexao_novo_banco = new mysqli($server, $user, $password, $nome_novo_banco);

                // Verifica se a conexão foi estabelecida
                if ($conexao_novo_banco->connect_error) {
                    die("Erro na conexão com o banco de dados: " . $conexao_novo_banco->connect_error);
                }

                // Executa o script SQL do arquivo de backup
                $sql = file_get_contents($diretorio_destino . $nome_arquivo);
                if ($conexao_novo_banco->multi_query($sql) === TRUE) {
                    echo "Backup restaurado com sucesso!";
                } else {
                    echo "Erro ao restaurar o backup: " . $conexao_novo_banco->error;
                }

                // Fecha a conexão com o novo banco de dados
                $conexao_novo_banco->close();

            } else {
                echo "Erro ao criar o banco de dados: " . $conn->error;
            }

        } else {
            echo "Erro ao mover o arquivo para o diretório de destino.";
        }

    } else {
        echo "Erro ao enviar o arquivo de backup.";
    }
}
?>
</div>

</body>
</html>
