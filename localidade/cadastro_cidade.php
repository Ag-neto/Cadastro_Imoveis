<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cidade</title>
    <link rel="stylesheet" href="../style/cadastro_cidade.css">
    <script>
        // Função para filtrar as cidades na tabela
        function filtrarCidades() {
            const input = document.getElementById('campoBusca');
            const filtro = input.value.toUpperCase();
            const tabela = document.getElementById('tabelaCidades');
            const linhas = tabela.getElementsByTagName('tr');

            for (let i = 1; i < linhas.length; i++) { // Começa na linha 1 para ignorar o cabeçalho
                const colunas = linhas[i].getElementsByTagName('td');
                const nomeCidade = colunas[0].innerText.toUpperCase();
                const estado = colunas[1].innerText.toUpperCase();

                if (nomeCidade.includes(filtro) || estado.includes(filtro)) {
                    linhas[i].style.display = '';
                } else {
                    linhas[i].style.display = 'none';
                }
            }
        }
    </script>
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
                    <input type="text" id="nome_cidade" name="nome_cidade" placeholder="Ex: JOÃO PESSOA" required oninput="this.value = this.value.toUpperCase()">
                </div>
            </div>

            <!-- Estado -->
            <div class="form-group">
                <div class="form-item">
                    <label for="estado">Estado:</label>
                    <select name="id_estado" id="id_estado" required>
                        <option value="" disabled selected>Selecione</option>
                        <?php
                        require_once "../conexao/conexao.php";

                        $sql = "SELECT * FROM estados";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['id_estado'] . '">' . $row['nome_estado'] . ' - ' . $row['sigla'] . '</option>';
                            }
                        }

                        ?>
                    </select>
                </div>
            </div>

            <!-- Botão para cadastrar cidade -->
            <button type="submit">Cadastrar Cidade</button>
            <a href="../index.php">Voltar para o menu</a>
        </form>
    </section>

    <!-- Seção de cidades cadastradas -->
    <section class="list-section">
        <h2>Cidades Cadastradas</h2>
        <input type="text" id="campoBusca" placeholder="Buscar cidade pelo nome..." onkeyup="filtrarCidades()">
        <table id="tabelaCidades">
            <thead>
                <tr>
                    <th>Nome da Cidade</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT c.idlocalizacao, c.nome_cidade, e.nome_estado 
                FROM localizacao c 
                INNER JOIN estados e ON c.id_estado = e.id_estado";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $idlocalizacao = $row['idlocalizacao'];
                        echo "<tr>
                                <td>" . $row['nome_cidade'] . "</td>
                                <td>" . $row['nome_estado'] . "</td>
                                <td>
                                    <div class='deletar'>
                                        <a class='deletar' href='deletar_cidade.php?id=$idlocalizacao' 
                                           onclick=\"return confirm('Deseja realmente excluir esta cidade?');\">Deletar</a>
                                    </div>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>Nenhuma cidade cadastrada</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>
</body>

</html>