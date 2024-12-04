<?php
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
$result = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$bd'");

if ($result->num_rows == 0) {
    // Verifica se a página atual já é "restaurar.php"
    if (basename($_SERVER['PHP_SELF']) !== 'restaurar.php') {
        header("Location: Backup/restaurar.php");
        exit;
    } else {
        // Apenas carrega a página restaurar.php sem nenhuma interrupção
        include '../Backup/restaurar.php';
        exit;
    }
}

// Conecta ao banco de dados
$conn = new mysqli($server, $user, $password, $bd);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

//função para capturar ipv4 do dispositivo e ser exibido no LOG
function get_ip_address() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // IP de um cliente ou proxy
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // IP de um proxy
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // IP direto
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }
    
    return $ip_address;
}

// Função para registrar LOG's
function log_action($action) {
    global $conn; // Usa a conexão global para evitar criar uma nova conexão dentro da função

    $ip_address = get_ip_address();

    // Prepara e vincula a declaração
    $stmt = $conn->prepare("INSERT INTO logs (ip_address, action) VALUES (?, ?)");
    $stmt->bind_param("ss", $ip_address, $action);

    // Executa a declaração
    if (!$stmt->execute()) {
        echo "Erro ao registrar o log: " . $stmt->error;
    }

    // Fecha a declaração
    $stmt->close();
}

function mostra_data($data){
    $d = explode('-', $data);
    $escreve = $d[2] . "/" . $d[1] . "/" . $d[0];
    return $escreve;
}

function registrarLogVencimento($idPagamento, $descricao, $urlDestino, $conn)
{
    $acao = "Notificação de Vencimento";
    $idUsuario = $_SESSION['id_usuario'] ?? 1; // Usuário logado ou usuário padrão
    $nivelAcesso = $_SESSION['idnivel_acesso'] ?? 1; // Nível de acesso padrão
    $dataAtual = date("Y-m-d H:i:s");

    // Insere o log na tabela
    $sql = "INSERT INTO logs (acao, descricao, url_destino, id_pagamento, id_usuario, nivel_acesso, data) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiiis", $acao, $descricao, $urlDestino, $idPagamento, $idUsuario, $nivelAcesso, $dataAtual);

    if (!$stmt->execute()) {
        error_log("Erro ao registrar log: " . $stmt->error);
    }

    $stmt->close();
}
?>
