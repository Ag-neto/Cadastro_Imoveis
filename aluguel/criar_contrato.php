<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Contrato de Aluguel</title>
    <link rel="stylesheet" href="style/contrato_style.css">
    <link rel="stylesheet" href="../style/criar_contrato.css">
</head>

<body>
    <header>
        <h1>Cadastro de Contrato de Aluguel</h1>
    </header>

    <section class="form-section">
        <h2>Informações do Contrato</h2>
        <form id="contrato-form">
            <!-- Escolha o tipo de contrato -->
            <div class="form-group">
                <input type="checkbox" name="opcao" id="checkbox1" value="venda">
                <label for="checkbox1">Venda</label><br>

                <input type="checkbox" name="opcao" id="checkbox2" value="aluguel">
                <label for="checkbox1">Aluguel</label><br>
            </div>

            <!-- Escolha da propriedade -->
            <div class="form-group">
                <div class="form-item">
                    <label for="propriedade">Propriedade:</label>
                    <select id="propriedade" name="propriedade" required>
                        <option value="">Selecione a Propriedade</option>
                        <option value="1">Apartamento Central</option>
                        <option value="2">Casa Verde</option>
                        <option value="3">Loja Comercial</option>
                    </select>
                </div>
            </div>

            <!-- Escolha do inquilino -->
            <div class="form-group">
                <div class="form-item">
                    <label for="inquilino">Inquilino:</label>
                    <select id="inquilino" name="inquilino" required>
                        <option value="">Selecione o Inquilino</option>
                        <option value="1">João da Silva</option>
                        <option value="2">Maria Oliveira</option>
                        <option value="3">Carlos Pereira</option>
                    </select>
                </div>
            </div>

            <!-- Detalhes do contrato -->
            <div class="form-group">
                <div class="form-item">
                    <label for="valor">Valor do Aluguel (R$):</label>
                    <input type="number" id="valor" name="valor" placeholder="Ex: 1200" required>
                </div>

                <div class="form-item">
                    <label for="data_inicio">Data de Início:</label>
                    <input type="date" id="data_inicio" name="data_inicio" required>
                </div>

                <div class="form-item">
                    <label for="data_fim">Data de Término:</label>
                    <input type="date" id="data_fim" name="data_fim" required>
                </div>
            </div>

            <!-- Botão para criar contrato -->
            <button type="submit">Criar Contrato</button>

            <a href="../index.php">Voltar para o menu</a>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedade</p>
    </footer>
</body>

</html>