<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_pagamento'])) {
    $id_pagamento = $_POST['id_pagamento'];
    $valor = $_POST['valor'];

    // Verificar a data de vencimento do pagamento
    $sql = "SELECT data_vencimento, contratos.id_propriedade 
            FROM pagamentos 
            JOIN contratos ON pagamentos.id_contrato = contratos.id_contratos 
            WHERE id_pagamento = $id_pagamento";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data_vencimento = $row['data_vencimento'];
        $id_propriedade = $row['id_propriedade'];
    } else {
        echo "Pagamento não encontrado.";
        exit;
    }

    // Obter a data atual
    $dataAtual = date('Y-m-d');

    // Verificar se o pagamento foi feito após a data de vencimento
    if ($dataAtual > $data_vencimento) {
        // Atualiza o status para "pago_vencido"
        $sql_update = "UPDATE pagamentos SET status = 'pago_vencido' WHERE id_pagamento = $id_pagamento";
    } else {
        // Atualiza o status para "pago"
        $sql_update = "UPDATE pagamentos SET status = 'pago' WHERE id_pagamento = $id_pagamento";
    }

    if ($conn->query($sql_update) === TRUE) {
        echo "Pagamento confirmado com sucesso!";

        // Inserir o movimento financeiro na conta corrente
        $descricao = "Pagamento de aluguel";
        $tipo_movimento = "receita";
        $data_movimento = date('Y-m-d');

        // Consultar o saldo atual
        $saldo_atual_sql = "SELECT saldo_acumulado FROM conta_corrente_propriedade 
                            WHERE id_propriedade = $id_propriedade 
                            ORDER BY id_movimento DESC 
                            LIMIT 1";
        $result = $conn->query($saldo_atual_sql);
        $saldo_atual = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['saldo_acumulado'] : 0;

        // Calcular o novo saldo acumulado
        $novo_saldo = $saldo_atual + $valor;

        // Inserir o movimento
        $sql_insert_movimento = "INSERT INTO conta_corrente_propriedade (id_propriedade, descricao, valor, data_movimento, tipo_movimento, saldo_acumulado) 
                                 VALUES ($id_propriedade, '$descricao', $valor, '$data_movimento', '$tipo_movimento', $novo_saldo)";

        if ($conn->query($sql_insert_movimento) === TRUE) {
            echo "Movimento inserido com sucesso!";
        } else {
            echo "Erro ao inserir movimento: " . $conn->error;
        }

        // Redirecionar de volta para o controle financeiro ou onde desejar
        header("Location: controle_financas.php");
        exit;
    } else {
        echo "Erro ao confirmar o pagamento: " . $conn->error;
    }
}
?>
