<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}

$id_cliente = $_SESSION["id_cliente"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['comprovante'])) {
    $id_pagamento = $_POST['id_pagamento'];
    $arquivo = $_FILES['comprovante'];

    if ($arquivo['error'] == 0) {
        $pasta = 'uploads/';
        $nomeArquivo = uniqid() . "_" . basename($arquivo['name']);
        $caminhoCompleto = $pasta . $nomeArquivo;

        if (move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto)) {
            // Atualiza o status para "Confirmando Pagamento"
            $sql = "UPDATE pagamentos SET comprovante = '$nomeArquivo', status = 'confirmando' WHERE id_pagamento = $id_pagamento";
            if ($conn->query($sql) === TRUE) {
                echo "Comprovante anexado com sucesso!";
            } else {
                echo "Erro ao atualizar o status do pagamento: " . $conn->error;
            }
        } else {
            echo "Erro ao mover o arquivo para o diretório de uploads.";
        }
    } else {
        echo "Erro ao enviar o arquivo.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Pagamentos</title>
    <link rel="stylesheet" href="../style/pag_cliente.css">
</head>

<body>
    <header>
        <h1>Gestão de Pagamentos</h1>
    </header>

    <section class="payment-history">
        <h2>Histórico de Pagamentos</h2>
        <table>
            <thead>
                <tr>
                    <th>Propriedade</th>
                    <th>Cliente</th>
                    <th>Valor (R$)</th>
                    <th>Data de Vencimento</th>
                    <th>Status</th>
                    <th>Anexar Comprovante</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consultar apenas os pagamentos do cliente específico
                $sql = "SELECT p.id_pagamento, propriedade.nome_propriedade, cliente.nome_cliente, p.valor, p.data_vencimento, p.status
                        FROM pagamentos AS p
                        JOIN contratos ON p.id_contrato = contratos.id_contratos
                        JOIN cliente ON contratos.id_cliente = cliente.idcliente
                        JOIN propriedade ON contratos.id_propriedade = propriedade.idpropriedade
                        WHERE cliente.idcliente = $id_cliente
                        ORDER BY p.data_vencimento ASC";

                $result = $conn->query($sql);

                // Iterar sobre os resultados e exibir cada pagamento
                if ($result->num_rows > 0) {
                    while ($pagamento = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $pagamento['nome_propriedade']; ?></td>
                            <td><?php echo $pagamento['nome_cliente']; ?></td>
                            <td><?php echo 'R$ ' . number_format($pagamento['valor'], 2, ',', '.'); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($pagamento['data_vencimento'])); ?></td>
                            <td><?php echo ucfirst($pagamento['status']); ?></td>
                            <td>
                                <?php if ($pagamento['status'] == 'vencido') : ?>
                                    <?php
                                    // Verifica se já existe uma notificação para este pagamento
                                    $sqlVerificarLog = "SELECT COUNT(*) AS total FROM logs WHERE id_usuario = ? AND acao = 'Notificação de Vencimento' AND descricao = 'Pagamento vencido para confirmação' AND id_pagamento = ?";
                                    $stmtVerificarLog = $conn->prepare($sqlVerificarLog);
                                    $stmtVerificarLog->bind_param("ii", $_SESSION['idusuario'], $pagamento['id_pagamento']);
                                    $stmtVerificarLog->execute();
                                    $resultadoVerificacao = $stmtVerificarLog->get_result();
                                    $logExistente = $resultadoVerificacao->fetch_assoc()['total'];
                                    $stmtVerificarLog->close();

                                    // Se não houver uma notificação de vencimento existente, insere a nova notificação
                                    if ($logExistente == 0) {
                                        registrarLogVencimento($_SESSION['idusuario'], $_SESSION['idnivel_acesso'], 'Notificação de Vencimento', 'Pagamento vencido para confirmação', 'pag_cliente.php', $pagamento['id_pagamento']);
                                    }
                                    ?>
                                <?php elseif ($pagamento['status'] == 'pendente') : ?>
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id_pagamento" value="<?php echo $pagamento['id_pagamento']; ?>">
                                        <input type="file" name="comprovante" accept=".pdf, .jpg, .jpeg, .png" required>
                                        <button type="submit">Anexar Comprovante</button>
                                    </form>
                                <?php elseif ($pagamento['status'] == 'confirmando') : ?>
                                    <span>Aguardando confirmação</span>
                                <?php else : ?>
                                    <button class="view-btn">Ver Comprovante</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhum pagamento encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Botão Voltar -->
        <div class="back-button">
            <a href="../index.php" class="btn-voltar">Voltar</a>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedade</p>
    </footer>
</body>

</html>