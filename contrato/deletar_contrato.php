<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_contrato'])) {
        $id_contrato = intval($_POST['id_contrato']);
        $id_propriedade = intval($_POST['id_propriedade']); // Converte para inteiro para evitar SQL Injection

        $id_situacao_para_alugar = 2;

        // Busca os IDs dos pagamentos vinculados ao contrato
        $sql_pagamentos = "SELECT id_pagamento FROM pagamentos WHERE id_contrato = $id_contrato";
        $result_pagamentos = $conn->query($sql_pagamentos);

        if ($result_pagamentos->num_rows > 0) {
            // Deleta os registros na tabela logs associados aos pagamentos encontrados
            while ($pagamento = $result_pagamentos->fetch_assoc()) {
                $id_pagamento = $pagamento['id_pagamento'];
                $sql_notificacao_logs = "DELETE FROM logs WHERE id_pagamento = $id_pagamento";
                if (!mysqli_query($conn, $sql_notificacao_logs)) {
                    echo "<p class='error'>Erro ao deletar logs: " . mysqli_error($conn) . "</p>";
                    exit;
                }
            }
        }

        // Deletar os pagamentos relacionados
        $sql_deletar_pagamentos = "DELETE FROM pagamentos WHERE id_contrato = $id_contrato";
        if (!mysqli_query($conn, $sql_deletar_pagamentos)) {
            echo "<p class='error'>Erro ao deletar pagamentos: " . mysqli_error($conn) . "</p>";
            exit;
        }

        // Deletar os documentos relacionados
        $sql_documentos = "DELETE FROM documentacao_contrato WHERE id_contrato = $id_contrato";
        if (!mysqli_query($conn, $sql_documentos)) {
            echo "<p class='error'>Erro ao deletar documentos: " . mysqli_error($conn) . "</p>";
            exit;
        }

        // Deletar o contrato
        $sql_contrato = "DELETE FROM contratos WHERE id_contratos = $id_contrato";
        if (!mysqli_query($conn, $sql_contrato)) {
            echo "<p class='error'>Erro ao deletar contrato: " . mysqli_error($conn) . "</p>";
            exit;
        }

        // Atualizar a situação da propriedade
        $sql_situacao = "UPDATE propriedade SET id_situacao = '$id_situacao_para_alugar' WHERE idpropriedade = '$id_propriedade'";
        if (!mysqli_query($conn, $sql_situacao)) {
            echo "<p class='error'>Erro ao atualizar situação da propriedade: " . mysqli_error($conn) . "</p>";
            exit;
        }

        // Redireciona após a exclusão bem-sucedida
        header('Location: listar_contratos.php?message=Contrato deletado com sucesso.');
        exit();
    } else {
        echo "<p class='error'>ID do contrato não especificado.</p>";
    }
} else {
    echo "<p class='error'>Método de requisição inválido.</p>";
}
