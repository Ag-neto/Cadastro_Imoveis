<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pagamento'])) {
    $id_pagamento = $_POST['id_pagamento'];

    // Atualiza o status para "Pago"
    $sql = "UPDATE pagamentos SET status = 'pago' WHERE id_pagamento = $id_pagamento";
    
    if ($conn->query($sql) === TRUE) {
        echo "Pagamento confirmado com sucesso!";
        // Redirecionar de volta para o controle financeiro ou onde desejar
        header("Location: controle_financas.php");
        exit;
    } else {
        echo "Erro ao confirmar o pagamento: " . $conn->error;
    }
}
?>
