<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pagamento'])) {
    $id_pagamento = $_POST['id_pagamento'];

    // Verificar a data de vencimento do pagamento
    $sql = "SELECT data_vencimento FROM pagamentos WHERE id_pagamento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_pagamento);
    $stmt->execute();
    $stmt->bind_result($data_vencimento);
    $stmt->fetch();
    $stmt->close();

    // Obter a data atual
    $dataAtual = date('Y-m-d');

    // Verificar se o pagamento foi feito após a data de vencimento
    if ($dataAtual > $data_vencimento) {
        // Atualiza o status para "pago_vencido" se a data atual é posterior à data de vencimento
        $sql = "UPDATE pagamentos SET status = 'pago_vencido' WHERE id_pagamento = ?";
    } else {
        // Atualiza o status para "pago" se ainda está dentro do prazo
        $sql = "UPDATE pagamentos SET status = 'pago' WHERE id_pagamento = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_pagamento);

    if ($stmt->execute()) {
        echo "Pagamento confirmado com sucesso!";
        // Redirecionar de volta para o controle financeiro ou onde desejar
        header("Location: controle_financas.php");
        exit;
    } else {
        echo "Erro ao confirmar o pagamento: " . $stmt->error;
    }

    $stmt->close();
}
?>
