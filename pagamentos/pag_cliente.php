<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Pagamentos de Aluguel</title>
    <link rel="stylesheet" href="../style/pag_cliente.css">
</head>
<body>
    <header>
        <h1>Gestão de Pagamentos de Aluguel</h1>
    </header>

    <section class="payment-history">
        <h2>Histórico de Pagamentos</h2>
        <table>
            <thead>
                <tr>
                    <th>Propriedade</th>
                    <th>Inquilino</th>
                    <th>Valor (R$)</th>
                    <th>Data de Vencimento</th>
                    <th>Status</th>
                    <th>Anexar Comprovante</th>
                </tr>
            </thead>
            <tbody>
                <!-- Pagamento mais recente pendente -->
                <tr class="pending">
                    <td>Apartamento - Centro</td>
                    <td>João Silva</td>
                    <td>1200.00</td>
                    <td>2024-10-10</td>
                    <td>Pendente</td>
                    <td>
                        <button class="upload-btn">Anexar Comprovante</button>
                        <input type="file" class="file-input" accept=".pdf, .jpg, .jpeg, .png" style="display: none;">
                    </td>
                </tr>
                <!-- Pagamentos anteriores -->
                <tr>
                    <td>Casa - Zona Norte</td>
                    <td>Maria Oliveira</td>
                    <td>1000.00</td>
                    <td>2024-09-10</td>
                    <td>Pago</td>
                    <td>
                        <button class="view-btn">Ver Comprovante</button>
                    </td>
                </tr>
                <tr>
                    <td>Apartamento - Centro</td>
                    <td>João Silva</td>
                    <td>1200.00</td>
                    <td>2024-08-10</td>
                    <td>Pago</td>
                    <td>
                        <button class="view-btn">Ver Comprovante</button>
                    </td>
                </tr>
                <!-- Adicionar mais pagamentos anteriores aqui -->
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

    <script>
        document.querySelectorAll('.upload-btn').forEach((button, index) => {
            button.addEventListener('click', function() {
                const fileInput = this.nextElementSibling;
                fileInput.click();
                fileInput.addEventListener('change', function() {
                    if (fileInput.files.length > 0) {
                        alert('Comprovante anexado com sucesso!');
                    }
                });
            });
        });
    </script>
</body>
</html>
