<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERRO</title>
    <link rel="stylesheet" href="../style/erroDeletarChaveEstrangeira.css">
</head>

<body>
    <div class="container">
        <?php
        $id = $_GET["id"] ?? "";
        // Verifica se há contratos associados à propriedade
        $sqlCheck = "SELECT COUNT(*) AS total FROM contratos WHERE id_propriedade = $id";
        $resultCheck = mysqli_query($conn, $sqlCheck);
        $rowCheck = mysqli_fetch_assoc($resultCheck);
        if ($rowCheck['total'] > 0) {
            // Exibe mensagem informando que não é possível excluir
            echo "<strong>Não é possível excluir a propriedade! <br> Há um contrato associado a ela. </strong>";
        } else {
            // Primeiro, deleta os registros da tabela conta_corrente_propriedade que referenciam esta propriedade
            $sql2 = "DELETE FROM conta_corrente_propriedade WHERE id_propriedade = $id";
            if (mysqli_query($conn, $sql2)) {
                // Depois, deleta os registros da tabela documentacao_propriedade
                $sql1 = "DELETE FROM documentacao_propriedade WHERE id_propriedade = $id";
        
                if (mysqli_query($conn, $sql1)) {
                    // Agora tenta deletar da tabela propriedade
                    $sql = "DELETE FROM propriedade WHERE idpropriedade = $id";
        
                    if (mysqli_query($conn, $sql)) {
                        echo "Deletado com sucesso!";
                        header('Location: listar_propriedades.php');
                        exit;
                    } else {
                        echo "Erro ao deletar da tabela propriedade: " . mysqli_error($conn);
                    }
                } else {
                    echo "Erro ao deletar da tabela documentacao_propriedade: " . mysqli_error($conn);
                }
            } else {
                echo "Erro ao deletar da tabela conta_corrente_propriedade: " . mysqli_error($conn);
            }
        }
        ?>
        <a href="detalhes_propriedade.php?id=<?php echo $id; ?>">Voltar</a>
    </div>
</body>

</html>
