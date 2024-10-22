<?php 
    $id_propriedade = $_GET['id_propriedade'] ?? 1;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style/style_conta_corrente.css">
</head>
<body>
<section class="form-section">
        <h3>Adicionar Movimento Financeiro</h3>
        <form method="POST" action="add_movimento.php">
            <input type="hidden" name="id_propriedade" value="<?php echo $id_propriedade; ?>">
            <label for="descricao">Descrição:</label>
            <input type="text" id="descricao" name="descricao" required oninput="this.value = this.value.toUpperCase()">

            <label for="valor">Valor (R$):</label>
            <input type="number" id="valor" name="valor" step="0.01" required>

            <label for="data_movimento">Data do Movimento</label>
            <input type="date" name="data_movimento" id="data_movimento">

            <label for="tipo_movimento">Tipo de Movimento:</label>
            <select id="tipo_movimento" name="tipo_movimento" required>
                <option value="Receita">Receita</option>
                <option value="Despesa">Despesa</option>
            </select>

            <button type="submit">Salvar</button>
        </form>
        <a href="contas_correntes.php">Voltar</a>
    </section>
</body>
</html>