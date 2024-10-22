<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <main>
        <section class="form-section">
            <?php

            require_once "../conexao/conexao.php";

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id_propriedade'];
                $descricao = $_POST['descricao'];
                $valor = $_POST['valor'];
                $data_movimento = $_POST['data_movimento'];
                $tipo_movimento = $_POST['tipo_movimento'];

                // Busca o saldo_acumulado anterior da propriedade em questão
                $sql_saldo_acumulado = "SELECT saldo_acumulado FROM conta_corrente_propriedade WHERE id_propriedade = $id ORDER BY id_movimento DESC LIMIT 1";
                $dados_saldo = mysqli_query($conn, $sql_saldo_acumulado);
                $saldo_acumulado = mysqli_fetch_assoc($dados_saldo)['saldo_acumulado'] ?? 0;

                if ($tipo_movimento == "Receita") {
                    $saldo_acumulado_insert = $saldo_acumulado + $valor;

                    $sql = "INSERT INTO conta_corrente_propriedade (id_propriedade, descricao, valor, data_movimento, tipo_movimento, saldo_acumulado) VALUES ('$id', '$descricao', '$valor', '$data_movimento', '$tipo_movimento', '$saldo_acumulado_insert')";

                    if (mysqli_query($conn, $sql)) {
                        header("Location: contas_correntes.php?id_propriedade=$id");
                    } else {
                        echo "<p class='error'>Movimentação não foi realizada!</p>";
                    }
                }elseif ($tipo_movimento == "Despesa") {
                    $saldo_acumulado_insert = $saldo_acumulado - $valor;

                    $sql = "INSERT INTO conta_corrente_propriedade (id_propriedade, descricao, valor, data_movimento, tipo_movimento, saldo_acumulado) VALUES ('$id', '$descricao', '$valor', '$data_movimento', '$tipo_movimento', '$saldo_acumulado_insert')";

                    if (mysqli_query($conn, $sql)) {
                        header("Location: contas_correntes.php?id_propriedade=$id");
                    } else {
                        echo "<p class='error'>Movimentação não foi realizada!</p>";
                    }
                }
                }
            ?>
        </section>

    </main>
</body>

</html>