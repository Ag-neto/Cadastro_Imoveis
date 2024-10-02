<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Propriedade</title>
    <link rel="stylesheet" href="../style/cadastro_propriedade_style.css">
</head>
<body>
    <header>
        <h1>Cadastro de Propriedade</h1>
    </header>

    <section class="form-section">
        <h2>Adicionar Propriedade</h2>
        <form id="imovel-form">
            <div class="form-group">
                <div class="form-item">
                    <label for="nome">Nome da Propriedade:</label>
                    <input type="text" id="nome" name="nome" placeholder="Ex: Apartamento Central" required>
                </div>

                <div class="form-item">
                    <label for="endereco">Endereço:</label>
                    <input type="text" id="endereco" name="endereco" placeholder="Ex: Rua ABC, 123" required>
                </div>

                <div class="form-item">
                    <label for="localidade">Localidade:</label>
                    <select name="localidade" id="localidade">
                        <option value=""></option>
                        <option value="bahia">Bahia</option>
                        <option value="joao_pessoa">João Pessoa</option>
                        <option value="pernambuco">Pernambuco</option>
                        <option value="Natal">Natal</option>
                    </select>
                </div>

                <div class="form-item">
                    <label for="preco">Valor - Adquirido (R$):</label>
                    <input type="number" id="preco" name="preco" placeholder="Ex: 250000" required>
                </div>

                <div class="form-item">
                    <label for="tamanho">Tamanho: (m²)</label>
                    <input type="number" id="tamanho" name="tamanho" required>
                </div>

                <div class="form-item">
                    <label for="situacao">Situação:</label>
                    <select id="situacao" name="situacao" required>
                        <option value=""></option>
                        <option value="disponivel_venda">Disponível para venda</option>
                        <option value="disponivel_aluguel">Disponível para aluguel</option>
                    </select>
                </div>

                <div class="form-item">
                    <label for="data">Data de Registro:</label>
                    <input type="date" id="data">
                </div>

                <div class="form-item">
                    <label for="documentos">Documentação</label>
                    <input type="file" name="documento" id="documento">
                </div>

                <div class="form-item">
                    <label for="tipo">Tipo de Propriedade:</label>
                    <select id="tipo" name="tipo" required>
                        <option value=""></option>
                        <option value="apartamento">Apartamento</option>
                        <option value="casa">Casa</option>
                        <option value="comercial">Comercial</option>
                        <option value="fazenda">Fazenda</option>
                    </select>
                </div>
            </div>

            <button type="submit">Cadastrar Propriedade</button>
            <a href="../index.php">Voltar para o menu</a>
        </form>
    </section>
</body>
</html>
