<?php
$servidor = "localhost";
$usuario = "root";
$senha = "root";
$bd = "controledepropriedade";

// Tentativa de conexão com o banco de dados
$conn = new mysqli($servidor, $usuario, $senha);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifica se o banco de dados existe
$result = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$bd'");

if ($result->num_rows == 0) {
    // O banco de dados não existe, redireciona para restaurar_backup.php
    header("Location: erro_banco.php");
    exit;
}

// Conecta ao banco de dados
$conn = new mysqli($servidor, $usuario, $senha, $bd);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

//função para capturar ipv4 do dispositivo e ser exibido no LOG
function get_ip_endereco() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // IP de um cliente ou proxy
        $ip_endereco = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // IP de um proxy
        $ip_endereco = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // IP direto
        $ip_endereco = $_SERVER['REMOTE_ADDR'];
    }
    
    return $ip_endereco;
}


// Função para registrar LOG's
function log_acao($acao) {
    global $conn; // Usa a conexão global para evitar criar uma nova conexão dentro da função

    $ip_endereco = get_ip_endereco();

    // Prepara e vincula a declaração
    $declaracao = $conn->prepare("INSERT INTO logs (ip_endereco, acao) VALUES (?, ?)");
    $declaracao->bind_param("ss", $ip_endereco, $acao);

    // Executa a declaração
    if (!$declaracao->execute()) {
        echo "Erro ao registrar o log: " . $declaracao->error;
    }

    // Fecha a declaração
    $declaracao->close();
}

function mostra_data($data){
    $d = explode('-', $data);
    $escreve = $d[2] . "/" . $d[1] . "/" . $d[0];
    return $escreve;
}
?>
