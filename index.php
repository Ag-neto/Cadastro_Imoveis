<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle - Gestão de Imóveis</title>
    <link rel="stylesheet" href="style/style_menu.css">
</head>
<body>
    <header>
        <h1>Painel de Controle - Gestão de Imóveis</h1>
        <button id="notification-btn">🔔 Notificações</button>
    </header>

    <nav>
        <ul>
            <li><a href="#" id="cadastrar-usuario">Cadastrar Usuário</a></li>
            <li><a href="cadastro_imovel.php">Cadastrar Novo Imóvel</a></li>
            <li><a href="#" id="pagamentos-aluguel">Pagamentos de Aluguel</a></li>
            <li><a href="#" id="gerar-contrato">Gerar Contrato de Aluguel</a></li>
        </ul>
    </nav>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" placeholder="Ex: Rua ABC, 123" required>

            <label for="preco">Preço (R$):</label>
            <input type="number" id="preco" name="preco" placeholder="Ex: 250000" required>

            <label for="tipo">Tipo de Imóvel:</label>
            <select id="tipo" name="tipo" required>
                <option value="apartamento">Apartamento</option>
                <option value="casa">Casa</option>
                <option value="comercial">Comercial</option>
            </select>

            <button type="submit">Adicionar Imóvel</button>
        </form>
    </section>

    <section class="list-section">
        <h2>Lista de Imóveis</h2>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Preço (R$)</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody id="imovel-list">
                <!-- Os imóveis serão adicionados aqui -->
            </tbody>
        </table>
    </section>

    <script src="script.js"></script>
</body>
</html>
