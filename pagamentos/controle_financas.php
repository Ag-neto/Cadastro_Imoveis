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
                    <th>Inquilino</th>
                    <th>Valor da Parcela</th>
                    <th>Data de Vencimento</th>
                    <th>Status do Pagamento</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>João da Silva</td>
                    <td>R$ 1.200,00</td>
                    <td>05/10/2024</td>
                    <td class="paid">Pago</td>
                </tr>
                <tr>
                    <td>Maria Oliveira</td>
                    <td>R$ 1.500,00</td>
                    <td>10/10/2024</td>
                    <td class="overdue">Pendente</td>
                </tr>
                <tr>
                    <td>Pedro Souza</td>
                    <td>R$ 2.000,00</td>
                    <td>15/10/2024</td>
                    <td class="paid">Pago</td>
                </tr>
                <tr>
                    <td>Larissa Costa</td>
                    <td>R$ 1.800,00</td>
                    <td>20/10/2024</td>
                    <td class="overdue">Pendente</td>
                </tr>
                <tr>
                    <td>Carlos Mendes</td>
                    <td>R$ 2.500,00</td>
                    <td>25/10/2024</td>
                    <td class="paid">Pago</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
