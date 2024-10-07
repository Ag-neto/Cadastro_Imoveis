<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cidade</title>
    <link rel="stylesheet" href="../style/cadastro_cidade.css">
</head>

<body>
    <header>
        <h1>Cadastro de Cidade</h1>
    </header>

    <section class="form-section">
        <h2>Informe os dados da cidade</h2>
        <form action="cidade_script.php" method="POST">
            <!-- Nome da cidade -->
            <div class="form-group">
                <div class="form-item">
                    <label for="nome">Nome da Cidade:</label>
                    <input type="text" id="nome_cidade" name="nome_cidade" placeholder="Ex: João Pessoa" required>
                </div>
            </div>

            <!-- Estado -->
            <div class="form-group">
                <div class="form-item">
                    <label for="estado">Estado:</label>
                    <select id="estado" name="estado" required>
                        <option value="" disabled selected>Selecione o Estado</option>
                        <option value="PB">Paraíba</option>
                        <option value="PE">Pernambuco</option>
                        <option value="RN">Rio Grande do Norte</option>
                        <option value="CE">Ceará</option>
                        <!-- Adicione outros estados conforme necessário -->
                    </select>
                </div>
            </div>

            <!-- Botão para cadastrar cidade -->
            <button type="submit">Cadastrar Cidade</button>
            <a href="../index.php">Voltar para o menu</a>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>
</body>

</html>
