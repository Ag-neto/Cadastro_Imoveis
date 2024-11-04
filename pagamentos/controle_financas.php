<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}

// Definir o mês e ano atuais para o filtro
$mesAtual = date('m');
$anoAtual = date('Y');

// Consulta SQL para obter pagamentos com status "pago" no mês e ano atuais
$sql = "SELECT valor FROM pagamentos WHERE (status = 'pago' OR status = 'pago_vencido') AND MONTH(data_vencimento) = ? AND YEAR(data_vencimento) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $mesAtual, $anoAtual);
$stmt->execute();
$result = $stmt->get_result();
$totalRecebidoMes = 0;
while ($pagamento = $result->fetch_assoc()) {
    $totalRecebidoMes += $pagamento['valor'];
}

// Consultar pagamentos com status "pendente"
$sql = "SELECT valor FROM pagamentos WHERE status = 'pendente' AND MONTH(data_vencimento) = ? AND YEAR(data_vencimento) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $mesAtual, $anoAtual);
$stmt->execute();
$result = $stmt->get_result();
$totalAEntrarMes = 0;
while ($pagamento = $result->fetch_assoc()) {
    $totalAEntrarMes += $pagamento['valor'];
}

// Consultar pagamentos com status "vencido"
$sql = "SELECT valor FROM pagamentos WHERE status = 'vencido' AND MONTH(data_vencimento) = ? AND YEAR(data_vencimento) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $mesAtual, $anoAtual);
$stmt->execute();
$result = $stmt->get_result();
$totalFaltandoEntrarMes = 0;
while ($pagamento = $result->fetch_assoc()) {
    $totalFaltandoEntrarMes += $pagamento['valor'];
}

$stmt->close();

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

// Consultar todos os pagamentos e atualizar o status se necessário
$sql = "SELECT cliente.nome_cliente, propriedade.nome_propriedade, p.id_pagamento, p.valor, p.data_vencimento, p.status, p.comprovante
        FROM pagamentos AS p
        JOIN contratos ON p.id_contrato = contratos.id_contratos
        JOIN cliente ON contratos.id_cliente = cliente.idcliente
        JOIN propriedade ON contratos.id_propriedade = propriedade.idpropriedade
        WHERE p.status != 'pendente' OR (p.status = 'pendente' AND MONTH(p.data_vencimento) = ? AND YEAR(p.data_vencimento) = ?)
        ORDER BY p.data_vencimento ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $mesAtual, $anoAtual);
$stmt->execute();
$result = $stmt->get_result();
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
                <strong>Total Recebido no Mês:</strong> R$ <?php echo number_format($totalRecebidoMes, 2, ',', '.'); ?>
            </div>
            <div class="total-item">
                <strong>Total a Entrar no Mês:</strong> R$ <?php echo number_format($totalAEntrarMes, 2, ',', '.'); ?>
            </div>
            <div class="total-item">
                <strong>Faltando Entrar no Mês:</strong> R$ <?php echo number_format($totalFaltandoEntrarMes, 2, ',', '.'); ?>
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
                // Iterar sobre os resultados e exibir cada pagamento
                if ($result->num_rows > 0) {
                    while ($pagamento = $result->fetch_assoc()) {
                        // Obtendo a data e hora do servidor
                        $dataServidor = date('Y-m-d');
                        $vencimento = $pagamento['data_vencimento'];
                        $timestampServidor = strtotime($dataServidor);
                        $timestampVencimento = strtotime($vencimento);

                        // Atualizando o status se necessário
                        if ($timestampServidor > $timestampVencimento && !$pagamento['comprovante'] && $pagamento['status'] !== 'pago') {
                            $id_pagamento = $pagamento['id_pagamento']; // Pegue o ID do pagamento
                            $update_sql = "UPDATE pagamentos SET status = 'vencido' WHERE id_pagamento = ?";
                            $stmt = $conn->prepare($update_sql);
                            $stmt->bind_param("i", $id_pagamento);
                            if ($stmt->execute()) {
                                $pagamento['status'] = 'vencido';
                            }
                            $stmt->close();
                        } elseif ($timestampServidor < $timestampVencimento && $pagamento['status'] === 'vencido') {
                            $id_pagamento = $pagamento['id_pagamento'];
                            $update_sql = "UPDATE pagamentos SET status = 'pendente' WHERE id_pagamento = ?";
                            $stmt = $conn->prepare($update_sql);
                            $stmt->bind_param("i", $id_pagamento);
                            if ($stmt->execute()) {
                                $pagamento['status'] = 'pendente';
                            }
                            $stmt->close();
                        }

                        // Define a classe CSS com base no status
                        $statusClass = '';
                        if ($pagamento['status'] == 'pendente') {
                            $statusClass = 'status-pendente';
                        } elseif ($pagamento['status'] == 'pago') {
                            $statusClass = 'status-pago';
                        } elseif ($pagamento['status'] == 'vencido') {
                            $statusClass = 'status-vencido';
                        } elseif ($pagamento['status'] == 'pago_vencido') {
                            $statusClass = 'status-pago_vencido';
                        }

                        // Exibe o status com o texto desejado
                        $statusTexto = ($pagamento['status'] == 'pago_vencido') ? 'Pago Com Vencimento' : ucfirst($pagamento['status']);
                ?>
                        <tr>
                            <td><?php echo $pagamento['nome_cliente']; ?></td>
                            <td><?php echo $pagamento['nome_propriedade']; ?></td>
                            <td>R$ <?php echo number_format($pagamento['valor'], 2, ',', '.'); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($pagamento['data_vencimento'])); ?></td>
                            <td class="<?php echo $statusClass; ?>"><?php echo $statusTexto; ?></td>
                            <td>
                                <?php if ($pagamento['status'] == 'pendente') : ?>
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="id_pagamento" value="<?php echo $pagamento['id_pagamento']; ?>">
                                        <input type="hidden" name="valor" value="<?php echo $pagamento['valor']; ?>">
                                        <input type="file" name="comprovante" required>
                                        <button type="submit">Enviar Comprovante</button>
                                    </form>
                                <?php elseif ($pagamento['status'] == 'confirmando') : ?>
                                    <form method="POST" action="confirmar_pagamento.php">
                                        <input type="hidden" name="id_pagamento" value="<?php echo $pagamento['id_pagamento']; ?>">
                                        <input type="hidden" name="valor" value="<?php echo $pagamento['valor']; ?>">
                                        <button type="submit">Confirmar Pagamento</button>
                                    </form>
                                <?php elseif (!empty($pagamento['comprovante'])) : ?>
                                    <a class="ver_comprovante" href="uploads/<?php echo $pagamento['comprovante']; ?>" target="_blank">Visualizar Comprovante</a>
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
    </div>
</body>

</html>