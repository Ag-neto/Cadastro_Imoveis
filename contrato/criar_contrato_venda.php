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
    <title>Cadastro de Contrato de Venda</title>
    <link rel="stylesheet" href="../style/criar_contrato.css">
</head>

<body>
    <header>
        <h1>Cadastro de Contrato de Venda</h1>
    </header>

    <section class="form-section">
        <h2>Informações do Contrato</h2>
        <form id="contrato-venda-form">

            <!-- Escolha da propriedade -->
            <div class="form-group">
                <div class="form-item">
                    <label for="propriedade">Propriedade:</label>
                    <select id="propriedade" name="propriedade" required>
                        <option value="">Selecione a Propriedade</option>
                        <option value="1">Apartamento Central</option>
                        <option value="2">Casa Verde</option>
                        <option value="3">Loja Comercial</option>
                    </select>
                </div>
            </div>

            <!-- Escolha do comprador -->
            <div class="form-group">
                <div class="form-item">
                    <label for="comprador">Comprador:</label>
                    <select id="comprador" name="comprador" required>
                        <option value="">Selecione o Comprador</option>
                        <option value="1">João da Silva</option>
                        <option value="2">Maria Oliveira</option>
                        <option value="3">Carlos Pereira</option>
                    </select>
                </div>
            </div>

            <!-- Detalhes do contrato de venda -->
            <div class="form-group">
                <div class="form-item">
                    <label for="valor_venda">Valor Total de Venda (R$):</label>
                    <input type="number" id="valor_venda" name="valor_venda" placeholder="Ex: 350000" required>
                </div>

                <div class="form-item">
                    <label for="valor_entrada">Valor Entrada (R$):</label>
                    <input type="number" id="valor_entrada" name="valor_entrada" placeholder="Ex: 15000" required>
                </div>

                <div class="form-item">
                    <label for="data_conclusao">Data de Conclusão:</label>
                    <input type="date" id="data_conclusao" name="data_conclusao" required>
                </div>
            </div>

            <!-- Botão para criar contrato -->
            <button type="submit">Criar Contrato</button>

            <a href="../index.php">Voltar para o menu</a>
        </form>
    </section>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedade</p>
    </footer>
</body>

</html>
