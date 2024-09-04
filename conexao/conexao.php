<?php
$server = "localhost";
$user = "root";
$password = "root";
$bd = "controledepropriedade";

// Tentativa de conexão com o banco de dados
$conn = new mysqli($server, $user, $password);

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

function registrarLogVencimento($acao, $descricao = null, $urlDestino = null, $idpagamento)
{
    global $conn;

    // Verifica se já existe um log para o mesmo pagamento e ação hoje
    $sqlVerificarLog = "SELECT COUNT(*) AS total FROM logs 
                        WHERE acao = ? AND id_pagamento = ?"; // Supondo que você tenha uma coluna 'data_registro' no formato DATE ou DATETIME
    $stmtVerificarLog = $conn->prepare($sqlVerificarLog);
    $stmtVerificarLog->bind_param("si", $acao, $idpagamento);
    $stmtVerificarLog->execute();
    $resultado = $stmtVerificarLog->get_result();
    $logExistente = $resultado->fetch_assoc()['total'];
    $stmtVerificarLog->close();

    // Se não houver log existente, insere o novo log
    if ($logExistente == 0) {
        // Preparando a consulta SQL para inserir o log
        $sql = "INSERT INTO logs (acao, descricao, url_destino, id_pagamento) 
                VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            // Associando os parâmetros
            $stmt->bind_param("sssi", $acao, $descricao, $urlDestino, $idpagamento);

            // Executando a consulta
            if (!$stmt->execute()) {
                error_log("Erro ao registrar log: " . $stmt->error);
            }

            // Fechar o statement
            $stmt->close();
        } else {
            error_log("Erro na preparação da consulta SQL para o log: " . $conn->error);
        }
    } else {
        error_log("Log já existe para o pagamento ID: $idpagamento e ação: $acao hoje.");
    }
}


?>
