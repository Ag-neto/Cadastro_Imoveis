<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idpropriedade = $_POST['idpropriedade'];
    $idcliente = $_POST['idcliente'];
    $valor_aluguel = $_POST['valor']; 
    $data_inicio = $_POST['data_inicio']; 
    $data_final = $_POST['data_fim']; 
    $vencimento = $_POST['cobranca']; 

    // Calcular o período de residência em dias
    $inicio = new DateTime($data_inicio);
    $fim = new DateTime($data_final);
    $periodo_residencia = $inicio->diff($fim)->days;

    if (!empty($idpropriedade) && !empty($idcliente) && !empty($valor_aluguel) && !empty($data_inicio) && !empty($data_final) && !empty($vencimento)) {
        if ($vencimento < 1 || $vencimento > 31) {
            echo "<p class='error'>O dia de vencimento deve estar entre 1 e 31!</p>";
        } else {
            $tipo_contrato = "ALUGUEL";
            $sql = "INSERT INTO contratos (id_propriedade, id_cliente, valor, data_inicio_residencia, data_final_residencia, tipo_contrato, vencimento, periodo_residencia) 
                    VALUES ('$idpropriedade', '$idcliente', '$valor_aluguel', '$data_inicio', '$data_final', '$tipo_contrato', '$vencimento', '$periodo_residencia')";

            if (mysqli_query($conn, $sql)) {
                $id_contrato = mysqli_insert_id($conn);
                $data_vencimento = new DateTime($vencimento);

                // Atualizar a situação da propriedade para "Alugado"
                $id_situacao_alugado = 7; // Supondo que "Alugado" tem o id_situacao = 7
                $sql_update_situacao = "UPDATE propriedade SET id_situacao = '$id_situacao_alugado' WHERE idpropriedade = '$idpropriedade'";
                mysqli_query($conn, $sql_update_situacao);

                while ($data_vencimento <= $fim) {
                    $sql_pagamento = "INSERT INTO pagamentos (id_contrato, valor, data_vencimento, status, comprovante) 
                                      VALUES ('$id_contrato', '$valor_aluguel', '{$data_vencimento->format('Y-m-d')}', 'pendente', '')";
                    mysqli_query($conn, $sql_pagamento);
                    $data_vencimento->modify('+1 month');
                }

                header('Location: listar_contratos.php');
                exit();
            } else {
                echo "<p class='error'>Não foi possível gerar o contrato! Erro: " . mysqli_error($conn) . "</p>";
            }
        }
    }
}
?>
