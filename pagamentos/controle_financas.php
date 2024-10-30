<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}

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
    <title>Gestão de Aluguéis - Painel do Gestor</title>
    <link rel="stylesheet" href="../style/controle_financas.css">
</head>

<body>
    <header>
        <div class="header-container">
            <h1>Painel de Gestão de Aluguéis</h1>
        </div>
    </header>
    <div class="btn-largura"><button class="back-button" onclick="window.location.href='../index.php'">← Voltar</button></div>
    <div class="container">
        <div class="totals">
            <div class="total-item">
                <strong>Total Recebido no Mês:</strong> R$ 15.000,00
            </div>
            <div class="total-item">
                <strong>Total a Entrar no Mês:</strong> R$ 25.000,00
            </div>
            <div class="total-item">
                <strong>Faltando Entrar:</strong> R$ 10.000,00
            </div>
        </div>

        <table class="rental-table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Propriedade</th>
                    <th>Valor</th>
                    <th>Data de Vencimento</th>
                    <th>Status</th>
                    <th>Comprovante</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require_once "../conexao/conexao.php";

                // Consultar todos os pagamentos, com as informações necessárias
                $sql = "SELECT cliente.nome_cliente, propriedade.nome_propriedade, p.id_pagamento, p.valor, p.data_vencimento, p.status, p.comprovante
                        FROM pagamentos AS p
                        JOIN contratos ON p.id_contrato = contratos.id_contratos
                        JOIN cliente ON contratos.id_cliente = cliente.idcliente
                        JOIN propriedade ON contratos.id_propriedade = propriedade.idpropriedade
                        ORDER BY p.data_vencimento ASC";

                $result = $conn->query($sql);

                // Iterar sobre os resultados e exibir cada pagamento
                if ($result->num_rows > 0) {
                    while ($pagamento = $result->fetch_assoc()) {
                ?>

                        <tr>
                            <td><?php echo $pagamento['nome_cliente']; ?></td>
                            <td><?php echo $pagamento['nome_propriedade']; ?></td>
                            <td><?php echo 'R$ ' . number_format($pagamento['valor'], 2, ',', '.'); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($pagamento['data_vencimento'])); ?></td>

                            <!-- Aqui entra o código de exibição do comprovante e confirmação -->
                            <td>
                                <?php
                                // Define a classe CSS com base no status
                                $statusClass = '';
                                if ($pagamento['status'] == 'pendente') {
                                    $statusClass = 'status-pendente';
                                } elseif ($pagamento['status'] == 'pago') {
                                    $statusClass = 'status-pago';
                                } elseif ($pagamento['status'] == 'vencido') {
                                    $statusClass = 'status-vencido';
                                }

                                // Obtendo a data e hora do servidor
                                $dataServidor = date('Y-m-d');

                                // Data a ser comparada
                                $vencimento = $pagamento['data_vencimento'];

                                // Convertendo as datas para timestamps
                                $timestampServidor = strtotime($dataServidor);
                                $timestampVencimento = strtotime($vencimento);

                                // Comparando as datas
                                if ($timestampServidor > $timestampVencimento && !$pagamento['comprovante'] && $pagamento['status'] !== 'pago') {
                                    // A data do servidor é posterior à data comparada e não há comprovante; atualiza o status para 'vencido'
                                    $id_pagamento = $pagamento['id_pagamento']; // Pegue o ID do pagamento

                                    // Atualiza o status no banco de dados
                                    $update_sql = "UPDATE pagamentos SET status = 'vencido' WHERE id_pagamento = ?";
                                    $stmt = $conn->prepare($update_sql);
                                    $stmt->bind_param("i", $id_pagamento);
                                    if ($stmt->execute()) {
                                        // Aqui você pode optar por não exibir a mensagem, já que a atualização será feita em background
                                        // echo "Status atualizado para 'vencido'.";
                                    } else {
                                        echo "Erro ao atualizar o status: " . $stmt->error;
                                    }
                                    $stmt->close();
                                } elseif ($timestampServidor < $timestampVencimento && !$pagamento['comprovante'] && $pagamento['status'] !== 'pago') {
                                    // A data do servidor é posterior à data comparada e não há comprovante; atualiza o status para 'vencido'
                                    $id_pagamento = $pagamento['id_pagamento']; // Pegue o ID do pagamento

                                    // Atualiza o status no banco de dados
                                    $update_sql = "UPDATE pagamentos SET status = 'pendente' WHERE id_pagamento = ?";
                                    $stmt = $conn->prepare($update_sql);
                                    $stmt->bind_param("i", $id_pagamento);
                                    if ($stmt->execute()) {
                                        // Aqui você pode optar por não exibir a mensagem, já que a atualização será feita em background
                                        // echo "Status atualizado para 'vencido'.";
                                    } else {
                                        echo "Erro ao atualizar o status: " . $stmt->error;
                                    }
                                }

                                ?>
                                <span class="<?php echo $statusClass; ?>"><?php echo ucfirst($pagamento['status']); ?></span>
                            </td>

                            <td>
                                <?php if ($pagamento['status'] == 'confirmando') : ?>
                                    <a href="uploads/<?php echo $pagamento['comprovante']; ?>" target="_blank">Ver Comprovante</a>
                                    <form method="POST" action="confirmar_pagamento.php">
                                        <input type="hidden" name="id_pagamento" value="<?php echo $pagamento['id_pagamento']; ?>">
                                        <button type="submit">Confirmar Pagamento</button>
                                    </form>
                                    <?php elseif ($pagamento['status'] == 'pendente') : ?>
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id_pagamento" value="<?php echo $pagamento['id_pagamento']; ?>">
                                        <input type="file" name="comprovante" accept=".pdf, .jpg, .jpeg, .png" required>
                                        <button type="submit">Anexar Comprovante</button>
                                    </form>
                                <?php else : ?>
                                    <span><a href="uploads/<?php echo $pagamento['comprovante']; ?>" target="_blank">Ver Comprovante</a></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum pagamento encontrado.</td></tr>";
                }
                ?>

            </tbody>
        </table>
    </div>
</body>

</html>