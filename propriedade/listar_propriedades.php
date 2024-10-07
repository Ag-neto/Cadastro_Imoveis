<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Propriedades</title>
    <link rel="stylesheet" href="../style/listar_propriedade.css">
</head>

<body>
    <header>
        <h1>Lista de Propriedades</h1>
    </header>

    <section class="form-section">
        <h2>Buscar Propriedade</h2>
        <form id="buscar-propriedade-form" method="GET" action="listar_propriedades.php">
            <div class="form-group">
                <label for="busca">Buscar por nome da propriedade ou cidade:</label>
                <input type="text" id="busca" name="busca" placeholder="Digite o nome da propriedade ou cidade">
            </div>

            <button type="submit">Buscar</button>
            <a href="../index.php" class="btn-voltar">Voltar</a>
            <a href="cadastro_propriedade.php" class="btn-criar_propriedade">Cadastrar Propriedade</a>
        </form>
    </section>

    <section class="propriedades-lista">
        <h2>Propriedades Cadastradas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Cidade</th>
                    <th>Valor (R$)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Exemplo de dados estáticos -->
                <tr>
                    <td>1</td>
                    <td>Apartamento Central</td>
                    <td>Apartamento</td>
                    <td>São Paulo</td>
                    <td>450.000,00</td>
                    <td><a href="detalhes_propriedade.php?id=1">Ver Detalhes</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Casa Verde</td>
                    <td>Casa</td>
                    <td>Rio de Janeiro</td>
                    <td>650.000,00</td>
                    <td><a href="detalhes_propriedade.php?id=2">Ver Detalhes</a></td>
                </tr>
                <!-- Aqui vamos fazer um loop para listar as propriedades dinâmicas -->
            </tbody>
        </table>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>

    <script src="../scripts/script_propriedades.js"></script>
</body>

</html>
