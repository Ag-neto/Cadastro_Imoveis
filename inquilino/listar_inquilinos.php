<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de inquilinos</title>
    <link rel="stylesheet" href="../style/listar_inquilino.css">
</head>

<body>
    <header>
        <h1>Lista de inquilinos</h1>
    </header>

    <section class="form-section">
        <h2>Buscar inquilino</h2>
        <form id="buscar-inquilino-form" method="GET" action="listar_inquilinos.php">
            <div class="form-group">
                <label for="busca">Buscar por nome da inquilino ou cidade:</label>
                <input type="text" id="busca" name="busca" placeholder="Digite o nome da inquilino ou cidade">
            </div>

            <button type="submit">Buscar</button>
            <a href="../index.php" class="btn-voltar">Voltar</a>
            <a href="cadastro_inquilino.php" class="btn-criar_inquilino">Cadastrar inquilino</a>
        </form>
    </section>

    <section class="inquilinos-lista">
        <h2>inquilinos Cadastrados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>RG</th>
                    <th>CPF</th>
                    <th>Endereco</th>
                    <th>Data Nascimento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <!-- Exemplo de dados estáticos -->
                <tr>
                    <td>1</td>
                    <td>Marcelo</td>
                    <td>33.475.579-7</td>
                    <td>533.403.840-02</td>
                    <td>Rua Arlindo Nogueira, Centro, Teresina</td>
                    <td>28/03/1990</td>
                    <td><a href="detalhes_inquilino.php?id=1">Ver Detalhes</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Lucas</td>
                    <td>33.475.579-7</td>
                    <td>533.403.840-02</td>
                    <td>Rua Arlindo Nogueira, Centro, Teresina</td>
                    <td>21/06/2000</td>
                    <td><a href="detalhes_inquilino.php?id=2">Ver Detalhes</a></td>
                </tr>
                <!-- Aqui vamos fazer um loop para listar as inquilinos dinâmicas -->
            </tbody>
        </table>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de inquilinos</p>
    </footer>

    <script src="../scripts/script_inquilinos.js"></script>
</body>

</html>
