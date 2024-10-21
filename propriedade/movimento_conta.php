<!DOCTYPE html>
<html lang="en">
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
            <input type="text" id="descricao" name="descricao" required>

            <label for="valor">Valor (R$):</label>
            <input type="number" id="valor" name="valor" step="0.01" required>

            <label for="tipo_movimento">Tipo de Movimento:</label>
            <select id="tipo_movimento" name="tipo_movimento" required>
                <option value="receita">Receita</option>
                <option value="despesa">Despesa</option>
            </select>

            <button type="submit">Adicionar Movimento</button>
        </form>
    </section>
</body>
</html>