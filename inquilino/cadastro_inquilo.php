<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Propriedade</title>
    <link rel="stylesheet" href="../style/cadastro_inquilino.css">
</head>
<body>
    <header>
        <h1>Cadastro de Inquilino</h1>
    </header>

    <section class="form-section">
        <h2>Adicionar Inquilino</h2>
        <form id="imovel-form">
            <div class="form-group">
                <div class="form-item">
                    <label for="nome">Nome do Inquilino:</label>
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
                    <label for="data_nascimento">Data de nascimento:</label>
                    <input type="date" name="data_nascimento" id="data_nascimento">
                </div> 

                <div class="form-item">
                    <label for="rg_numero">Registro Geral (RG):</label>
                    <input type="text" id="rg_numero" name="rg_numero" required>
                </div>
                
                <div class="form-item">
                    <label for="telefone">Celular:</label>
                    <input type="number" id="telefone" name="telefone" required>
                </div>

                <div class="form-item">
                    <label for="rg_pdf">Registro Geral - PDF (RG):</label>
                    <input type="file" name="rg_pdf" id="rg_pdf">
                </div>

                <div class="form-item">
                    <label for="cpf_numero">Cadastro de pessoa física (CPF):</label>
                    <input type="text" id="cpf_numero" name="cpf_numero" required>
                </div>

                <div class="form-item">
                    <label for="cpf_pdf">Cadastro de pessoa física (CPF):</label>
                    <input type="file" name="cpf_pdf" id="cpf_pdf">
                </div>

            </div>

            <button type="submit">Cadastrar Inquilino</button>
            <a href="../index.php">Voltar para o menu</a>
        </form>
    </section>
    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedade</p>
    </footer>
</body>
</html>
