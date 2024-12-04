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
    <title>Enviar Documentos</title>
    <link rel="stylesheet" href="../style/cadastrar_cidade.css">
</head>

<body>
    <header>
        <h1>Envio de Documentos</h1>
    </header>

    <main>
        <section class="form-section">
            <?php
            function enviarArquivos($conn, $error, $size, $name, $tmp_name)
            {
                if ($error) {
                    return false; // Indica falha no envio
                }
                if ($size > 2097152) {
                    return false; // Arquivo muito grande
                }

                $pasta = "arquivos/";
                $nome_arquivo_escapado = mysqli_real_escape_string($conn, $name);
                $novo_nome_arquivo = uniqid();
                $extensao = strtolower(pathinfo($nome_arquivo_escapado, PATHINFO_EXTENSION));

                if ($extensao != "pdf") {
                    return false; // Tipo de arquivo não suportado
                }

                $caminho_completo = $pasta . $novo_nome_arquivo . "." . $extensao;
                $deu_certo = move_uploaded_file($tmp_name, $caminho_completo);

                // Obtém o ID da última propriedade cadastrada
                $sql1 = "SELECT MAX(idcliente) AS idcliente FROM cliente";
                $dados = mysqli_query($conn, $sql1);
                $linha = mysqli_fetch_assoc($dados);
                $id_ultimo_cliente = $linha['idcliente'];

                if ($deu_certo) {
                    echo "<p>Arquivo enviado com sucesso! Para acessá-lo, clique aqui: <a target='_blank' href='" . $caminho_completo . "'>Download do arquivo</a></p>";

                    $sql = "INSERT INTO documentacao_cliente (nome_doc, path, data_upload, id_cliente) VALUES('$nome_arquivo_escapado', '$caminho_completo', NOW(), '$id_ultimo_cliente')";

                    // Executa a consulta para inserir os dados no banco de dados
                    if (mysqli_query($conn, $sql)) {
                        echo "<p class='success'>Documento salvo com sucesso!</p>";
                        return true; // Retorna verdadeiro se tudo ocorreu bem
                    } else {
                        echo "<p class='error'>Erro ao salvar os dados no banco de dados: " . mysqli_error($conn) . "</p>";
                        return false; // Retorna falso se ocorreu um erro ao salvar
                    }
                } else {
                    echo "<p class='error'>Falha ao mover o arquivo.</p>";
                    return false; // Retorna falso se a movimentação do arquivo falhou
                }
            }
            if (isset($_FILES['documentos'])) {
                $documentos = $_FILES['documentos'];
                $tudo_certo = true;

                foreach ($documentos['name'] as $index => $nome) {
                    // Chama a função e verifica se o envio foi bem-sucedido
                    $deu_certo = enviarArquivos($conn, $documentos['error'][$index], $documentos['size'][$index], $nome, $documentos["tmp_name"][$index]);
                    if (!$deu_certo) {
                        $tudo_certo = false;
                    }
                }

                // Obtém o ID da última propriedade cadastrada
                $sql1 = "SELECT MAX(idcliente) AS idcliente FROM cliente";
                $dados = mysqli_query($conn, $sql1);
                $linha = mysqli_fetch_assoc($dados);
                $id_ultimo_cliente = $linha['idcliente'];

                if ($tudo_certo) {
                    echo "<p>Todos os arquivos foram enviados!</p>";
                    header('Location: listar_clientes.php');
                } else {
                    echo "<p>Falha ao enviar 1 ou mais arquivos! Verifique o formato e tamanho (Max: 2MB)</p>";
                }
            }
            ?>
        </section>

        <a href="listar_clientes.php" class="button">Voltar</a>
    </main>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>
</body>

</html>