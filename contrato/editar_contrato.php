<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contrato</title>
    <link rel="stylesheet" href="../style/editar_contrato.css">
</head>

<body>
    <header>
        <h1>Editar Contrato</h1>
    </header>

    <section class="form-section">
        <h2>Informações do Contrato</h2>
        <form id="editar-contrato-form" action="atualizar_contrato.php" method="POST">

            <!-- ID do contrato (oculto) -->
            <input type="hidden" id="contrato_id" name="contrato_id" value="1"> <!-- Substitua pelo ID real -->

            <!-- Escolha da propriedade -->
            <div class="form-group">
                <div class="form-item">
                    <label for="propriedade">Propriedade:</label>
                    <select id="propriedade" name="propriedade" required>
                        <option value="1" selected>Apartamento Central</option>
                        <option value="2">Casa Verde</option>
                        <option value="3">Loja Comercial</option>
                    </select>
                </div>
            </div>

            <!-- Escolha do cliente -->
            <div class="form-group">
                <div class="form-item">
                    <label for="cliente">Cliente:</label>
                    <select id="cliente" name="cliente" required>
                        <option value="1" selected>João da Silva</option>
                        <option value="2">Maria Oliveira</option>
                        <option value="3">Carlos Pereira</option>
                    </select>
                </div>
            </div>

            <!-- Detalhes do contrato -->
            <div class="form-group">
                <div class="form-item">
                    <label for="valor">Valor (R$):</label>
                    <input type="number" id="valor" name="valor" placeholder="Ex: 450000" required value="450000">
                </div>

                <div class="form-item">
                    <label for="data_inicio">Data de Início:</label>
                    <input type="date" id="data_inicio" name="data_inicio" required value="2024-01-01">
                </div>

                <div class="form-item">
                    <label for="data_fim">Data de Término:</label>
                    <input type="date" id="data_fim" name="data_fim" value="2024-12-31">
                </div>
            </div>

            <!-- Botão para atualizar contrato -->
            <button type="submit">Salvar Alterações</button>

            <a href="../index.php">Voltar para o menu</a>
            <a href="listar_contratos.php">Voltar para contratos</a>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>
</body>

</html>
