<?php
// Conexão com o banco de dados
require_once '../conexao/conexao.php'; // Ajuste o caminho conforme necessário

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirmar'])) {
        if ($_POST['confirmar'] === 'Sim') {
            try {
                // Nome do banco a ser excluído
                $databaseName = 'controledepropriedade2';

                // Excluir o banco de dados
                $sql = "DROP DATABASE `$databaseName`";
                
                // Executar o comando com mysqli
                if ($conn->query($sql) === TRUE) {
                    echo "O banco de dados $databaseName foi excluído com sucesso.";
                    
                    session_unset(); // Limpa todas as variáveis de sessão
                    session_destroy(); // Destroi a sessão

                    header("Location: ../Backup/restaurar.php");
                } else {
                    echo "Erro ao excluir o banco de dados: " . $conn->error;
                }
            } catch (Exception $e) {
                echo "Erro ao excluir o banco de dados: " . $e->getMessage();
            }
        } elseif ($_POST['confirmar'] === 'Não') {
            // Redirecionar para index.php
            header("Location: ../index.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Banco de Dados</title>
    <link rel="stylesheet" href="../style/deletar_banco.css">

    <script>
        // Função para exibir o alerta de confirmação
        function confirmarExclusao(event) {
            // Exibe a mensagem de confirmação
            const confirmar = confirm("Tem certeza de que deseja excluir o banco de dados? Esta ação não pode ser desfeita.");
            
            // Se o usuário NÃO confirmar, impede o envio do formulário
            if (!confirmar) {
                event.preventDefault();
            }
        }
    </script>

</head>
<body>
    <div class="container">
        <h1>Excluir Banco de Dados</h1>
        <p>Tem certeza de que deseja excluir o banco de dados? Esta ação não pode ser desfeita.</p>
        <form method="post">
            <button type="submit" name="confirmar" value="Sim" onclick="confirmarExclusao(event)" class="btn-confirm">Sim, excluir</button>
            <button type="submit" name="confirmar" value="Não" class="btn-cancel">Não, cancelar</button>
        </form>
    </div>
</body>
</html>

