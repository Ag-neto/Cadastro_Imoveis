<?php
session_start();
require_once "../conexao/conexao.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../usuario/login.php");
    exit;
}

// Verifica se o parâmetro 'id' foi passado na URL
if (!isset($_GET['id'])) {
    echo "ID do contrato não fornecido.";
    exit;
}

$idContrato = (int)$_GET['id']; // Obtém o 'id' e garante que seja um número inteiro

// Prepara a consulta SQL
$sql = "SELECT 
    contratos.*,
    propriedade.nome_propriedade,
    propriedade.endereco AS endereco_propriedade,
    cliente.nome_cliente,
    cliente.rg_numero,
    cliente.cpf_numero,
    cliente.profissao,
    cliente.nacionalidade,
    cliente.cep,
    cliente.endereco AS endereco_cliente
FROM contratos
JOIN propriedade ON contratos.id_propriedade = propriedade.idpropriedade
JOIN cliente ON contratos.id_cliente = cliente.idcliente
WHERE contratos.id_contratos = $idContrato";

$result = $conn->query($sql);
$contrato = $result->fetch_assoc();

// Formatação da data
$dataFormatada = new DateTime($contrato['data_final_residencia']);
$dataFinalFormatada = $dataFormatada->format('d/m/Y');

function valorPorExtenso($valor = 0)
{
    $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
    $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");

    $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
    $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
    $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove");
    $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

    $z = 0;
    $valor = number_format($valor, 2, ".", ".");
    $inteiro = explode(".", $valor);
    for ($i = 0; $i < count($inteiro); $i++) {
        for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++) {
            $inteiro[$i] = "0" . $inteiro[$i];
        }
    }

    $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
    $rt = "";
    for ($i = 0; $i < count($inteiro); $i++) {
        $valor = $inteiro[$i];
        $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
        $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
        $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

        $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
        $t = count($inteiro) - 1 - $i;
        $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
        if ($valor == "000") $z++;
        elseif ($z > 0) $z--;
        if (($t == 1) && ($z > 0) && ($inteiro[0] > 0)) $r .= (($z > 1) ? " de " : "") . $plural[$t];
        if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
    }

    return ucfirst(trim($rt));
}

// Utilização no código
$valorVenda = $contrato['valor_aluguel']; // Supondo que 'valor_aluguel' é o valor da venda
$valorPorExtenso = valorPorExtenso($valorVenda);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Venda de Imóvel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        p {
            margin: 10px 0;
        }

        .signature {
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <h1>CONTRATO DE VENDA DE IMÓVEL</h1>

    <p>
        Pelo presente instrumento, ARNALDO DARDIS JÚNIOR, brasileiro, empresário, casado, RG n. 9 1155555-SSP/PB, CPF/MF n. 9 555.555.555-04, domiciliado na Rua Governador Antonio Mariz, nº 600, Bairro Portal do Sol, nesta cidade, adiante denominado VENDEDOR;
        e <?php echo $contrato['nome_cliente']; ?>, <?php echo $contrato['nacionalidade']; ?>, RG nº <?php echo $contrato['rg_numero']; ?>, CPF/MF nº <?php echo $contrato['cpf_numero']; ?>, domiciliado(a) na <?php echo $contrato['endereco_cliente']; ?>, Cep. <?php echo $contrato['cep']; ?>, adiante denominado COMPRADOR, têm entre si justo e contratado o que se segue:
    </p>

    <p>
        1. O VENDEDOR é senhor e legítimo proprietário da <?php echo $contrato['nome_propriedade']; ?>, situada na <?php echo $contrato['endereco_propriedade']; ?>, nesta cidade, pelo que, através do presente contrato, VENDI-A ao COMPRADOR.
    </p>

    <p>
        2. O valor da venda é de <?php echo 'R$ ' . number_format($valorVenda, 2, ',', '.'); ?>
        (<?php echo $valorPorExtenso; ?>), que será pago na forma acordada entre as partes.
    </p>

    <p>
        3. O VENDEDOR se compromete a entregar a propriedade em condições adequadas ao uso e gozando de pleno gozo e fruição.
    </p>

    <p>
        4. O COMPRADOR declara que recebeu a propriedade em perfeitas condições e aceita os termos deste contrato.
    </p>

    <p>
        5. As partes elegem o foro da situação do imóvel para dirimir quaisquer dúvidas ou litígios oriundos deste contrato, renunciando a qualquer outro.
    </p>

    <p>
        6. E, por estarem justos e contratados, as partes assinam o presente instrumento, em 02 (duas) vias de igual teor e forma, na presença de 02 (duas) testemunhas, para que surta seus jurídicos e legais efeitos.
    </p>

    <p>
        João Pessoa (PB), <?php echo date('d/m/Y'); ?>.
    </p>

    <div class="signature">
        <p>VENDEDOR:</p>
        <p>_______________________________</p>
        <p>ARNALDO DARDIS JÚNIOR</p>
        <br>
        <p>COMPRADOR:</p>
        <p>_______________________________</p>
        <p><?php echo $contrato['nome_cliente']; ?></p>
        <br>
        <p>TESTEMUNHAS:</p>
        <p>_______________________________</p>
        <p>_______________________________</p>
    </div>
</body>

</html>
