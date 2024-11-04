<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}

// Recebe os dados do formulário
$id = $_POST['id_contratos'];
$id_propriedade = $_POST['id_propriedade'];
$id_cliente = $_POST['id_cliente'];
$valor = $_POST['valor'];
$data_ini = $_POST['data_inicio'];
$data_fim = $_POST['data_fim'];
$vencimento = $_POST['vencimento'];

// Validação das datas
if (!DateTime::createFromFormat('Y-m-d', $data_ini) ||
    !DateTime::createFromFormat('Y-m-d', $data_fim) ||
    !DateTime::createFromFormat('Y-m-d', $vencimento)) {
    die("Uma ou mais datas estão em um formato inválido.");
}

// Crie objetos DateTime a partir das datas
$data_inicio = new DateTime($data_ini);
$data_final = new DateTime($data_fim);
$diferenca = $data_inicio->diff($data_final);
$periodo_residencia = $diferenca->days;

// Atualização do contrato
$sql = "UPDATE contratos SET 
        id_propriedade = '$id_propriedade', 
        id_cliente = '$id_cliente', 
        valor = '$valor', 
        data_inicio_residencia = '$data_ini', 
        vencimento = '$vencimento', 
        data_final_residencia = '$data_fim', 
        periodo_residencia = '$periodo_residencia' 
        WHERE id_contratos = '$id'";

if (mysqli_query($conn, $sql)) {
    echo "Contrato atualizado com sucesso!";
    
   // Inserindo pagamentos
$data_vencimento = new DateTime($vencimento);
$data_atual = new DateTime(); // Obter a data atual

while ($data_vencimento <= $data_final) {
    // Verifica se a data de vencimento é futura
    if ($data_vencimento > $data_atual) {
        // Verifica se já existe um pagamento com a mesma data de vencimento
        $sql_verifica = "SELECT COUNT(*) FROM pagamentos WHERE id_contrato = '$id' AND data_vencimento = '{$data_vencimento->format('Y-m-d')}'";
        $resultado_verifica = mysqli_query($conn, $sql_verifica);
        $quantidade = mysqli_fetch_row($resultado_verifica)[0];

        // Se não existir, insere o pagamento
        if ($quantidade == 0) {
            $sql_pagamento = "INSERT INTO pagamentos (id_contrato, valor, data_vencimento, status, comprovante) 
                              VALUES ('$id', '$valor', '{$data_vencimento->format('Y-m-d')}', 'pendente', '')";
            if (!mysqli_query($conn, $sql_pagamento)) {
                echo "Erro ao inserir pagamento: " . mysqli_error($conn); // Erro ao inserir pagamento
            }
        } else {
            // Se já existir, pula para o próximo mês
            echo "Pagamento para {$data_vencimento->format('Y-m-d')} já existe. Pulando para o próximo mês.<br>";
        }
    }
    $data_vencimento->modify('+1 month'); // Move para o próximo mês
}

    // Redireciona após a atualização bem-sucedida
    header('Location: detalhes_contrato_aluguel.php?id=' . $id);
    exit;
} else {
    echo "Erro ao atualizar contrato: " . mysqli_error($conn); // Mensagem de erro detalhada
}
?>
