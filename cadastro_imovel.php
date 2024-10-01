<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Imóveis</title>
    <link rel="stylesheet" href="style/cadastro_imoveis_style.css">
</head>
<body>
    <header>
        <h1>Controle de Imóveis</h1>
    </header>

    <section class="form-section">
        <h2>Adicionar Imóvel</h2>
        <form id="imovel-form">
            <label for="nome">Nome do Imóvel:</label>
            <input type="text" id="nome" name="nome" placeholder="Ex: Apartamento Central" required>

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" placeholder="Ex: Rua ABC, 123" required>

            <label for="estado">Unidade Federativa (UF):</label>
            <select id="tipo" name="tipo" required>
                <option value=""></option>
                <option value="Paraiba">Paraiba</option>
                <option value="Pernambuco">Pernambuco</option>
                <option value="Bahia">Bahia</option>
            </select>

            <label for="preco">Preço - Adquirido (R$):</label>
            <input type="number" id="preco" name="preco" placeholder="Ex: 250000" required>

            <label for="tipo">Tipo de Imóvel:</label>
            <select id="tipo" name="tipo" required>
                <option value=""></option>
                <option value="apartamento">Apartamento</option>
                <option value="casa">Casa</option>
                <option value="comercial">Comercial</option>
                <option value="fazenda">Fazenda</option>
            </select>

            <button type="submit">Adicionar Imóvel</button>

            <a href="index.php">Voltar para o menu</a>
        </form>
    </section>

<!--
    <section class="list-section">
        <h2>Lista de Imóveis</h2>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Endereço</th>
                    <th>Estado</th>
                    <th>Preço (R$)</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody id="imovel-list">
                 Os imóveis serão adicionados aqui 
            </tbody>
        </table>
    </section>
-->

    <script src="script.js"></script>
</body>
</html>
