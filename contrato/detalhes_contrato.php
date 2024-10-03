<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Contrato</title>
    <link rel="stylesheet" href="../style/style_detalhes.css">
</head>

<body>
    <header>
        <h1>Detalhes do Contrato</h1>
    </header>

    <section class="detalhes-contrato">
        <h2>Resumo do Contrato</h2>

        <div class="contrato-info">
            <p><strong>ID do Contrato:</strong> 1</p>
            <p><strong>Tipo de Contrato:</strong> Venda</p>
            <p><strong>Propriedade:</strong> Apartamento Central</p>
            <p><strong>Cliente:</strong> João da Silva</p>
            <p><strong>Valor (R$):</strong> 450.000,00</p>
            <p><strong>Data de Início:</strong> 01/01/2024</p>
            <p><strong>Data de Término:</strong> N/A</p>
        </div>

        <div class="acoes">
            <button onclick="window.history.back();">Voltar</button>
            <button onclick="editarContrato(1);">Editar Contrato</button>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>

    <script>
        function editarContrato(id) {
            window.location.href = `editar_contrato.php?id=${id}`;
        }
    </script>
</body>

</html>
