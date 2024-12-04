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
    <title>Seleção de Tipo de Contrato</title>
    <link rel="stylesheet" href="../style/tipo_contrato.css">
</head>

<body>
    <header>
        <h1>Selecione o Tipo de Contrato</h1>
    </header>

    <section class="selection-section">
        <div class="selection-group">
            <a href="criar_contrato_venda.php" class="selection-option">
                <h2>Contrato de Venda</h2>
            </a>

            <a href="criar_contrato_aluguel.php" class="selection-option">
                <h2>Contrato de Aluguel</h2>
            </a>
            
            <a href="criar_contrato_arrendamento.php" class="selection-option"> <!-- Adicionado arrendamento -->
                <h2>Contrato de Arrendamento</h2>
            </a>
        </div>
    </section>
    <a href="listar_contratos.php">Voltar</a>   

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedade</p>
    </footer>
</body>

</html>
