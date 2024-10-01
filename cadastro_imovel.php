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
        <h1>Controle de Propriedade</h1>
    </header>

    <section class="form-section">
        <h2>Adicionar Propriedade</h2>
        <form id="imovel-form">

            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" placeholder="Ex: Rua ABC, 123" required>

            <label for="estado">Unidade Federativa (UF):</label>
            <select id="tipo" name="tipo" required>
                <option value=""></option>
                <option value="Paraiba">Paraiba</option>
                <option value="Pernambuco">Pernambuco</option>
                <option value="Bahia">Bahia</option>
            </select>

            <label for="preco">Valor - Adquirido (R$):</label>
            <input type="number" id="preco" name="preco" placeholder="Ex: 250000" required>

            <label for="tamanho">Tamanho: (m²)</label>
            <input type="number" id="tamanho" name="tamanho" required>

            <label for="situacao">Situação:</label>
            <select id="situacao" name="situacao" required>
                <option value=""></option>
                <option value="Paraiba">Disponível para venda</option>
                <option value="Pernambuco">Disponível para aluguel</option>
            </select>

            <label for="preco">Data de Registro:</label>
            <input type="date" name="" id="">

            <label for="documentos">Documentação</label>
            <input type="file" name="documento" id="documento">

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
