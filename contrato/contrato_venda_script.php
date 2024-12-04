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
    $valor_venda = $_POST['valor_venda'];
    $valor_entrada = $_POST['valor_entrada'];
    $data_conclusao = $_POST['data_conclusao'];

    // Verificar campos obrigatórios
    if (!empty($idpropriedade) && !empty($idcliente) && !empty($valor_venda) && !empty($valor_entrada) && !empty($data_conclusao)) {
        $tipo_contrato = "VENDA";

        $sql = "INSERT INTO contratos (id_propriedade, id_cliente, valor, data_compra, tipo_contrato) 
                VALUES ('$idpropriedade', '$idcliente', '$valor_venda', '$data_conclusao', '$tipo_contrato')";

        // Atualizar a situação da propriedade para "Alugado"
        $id_situacao_venda = 6;
        $sql_update_situacao = "UPDATE propriedade SET id_situacao = '$id_situacao_venda' WHERE idpropriedade = '$idpropriedade'";
        mysqli_query($conn, $sql_update_situacao);

        if (mysqli_query($conn, $sql)) {
            header('Location: listar_contratos.php');
            exit();
        } else {
            echo "<p class='error'>Erro ao gerar contrato de venda: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p class='error'>Por favor, preencha todos os campos obrigatórios!</p>";
    }
}
?>

<a href="../index.php" class="button">Voltar para o menu</a>