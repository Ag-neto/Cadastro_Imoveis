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

$vencimento = new DateTime($contrato['vencimento']);
$dataFormatada = $vencimento->format('d/m/Y');
$dataFormatadaDia = $vencimento->format('d');

// Verifica se as datas estão disponíveis
if (!empty($contrato['data_inicio_residencia']) && !empty($contrato['data_final_residencia'])) {
    $dataInicio = new DateTime($contrato['data_inicio_residencia']);
    $dataFim = new DateTime($contrato['data_final_residencia']);

    // Calcula a diferença entre as datas
    $intervalo = $dataInicio->diff($dataFim);

    // Formata a saída
    $anos = $intervalo->y; // Quantidade de anos completos
    $meses = $intervalo->m; // Meses restantes

    if ($anos > 0) {
        $tempo = $anos . " ano(s)";
        if ($meses > 0) {
            $tempo .= " e " . $meses . " mês(es)";
        }
    } else {
        $tempo = $meses . " mês(es)";
    }
} else {
    $tempo = "Período não disponível";
}

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
$valorArrendamento = $contrato['valor_aluguel'];
$valorPorExtenso = valorPorExtenso($valorArrendamento);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Arrendamento</title>
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
    <h1>CONTRATO DE ARRENDAMENTO DE IMÓVEL</h1>

    <p>
        Pelo presente instrumento, ARNALDO DARDIS JÚNIOR, brasileiro, empresário, casado, RG n. 9 1155555-SSP/PB, CPF/MF n. 9 555.555.555-04, domiciliado na Rua Governador Antonio Mariz, nº 600, Bairro Portal do Sol, nesta cidade, adiante denominado ARRENDADOR;
        e <?php echo $contrato['nome_cliente']; ?>, <?php echo $contrato['nacionalidade']; ?>, RG nº <?php echo $contrato['rg_numero']; ?>, CPF/MF nº <?php echo $contrato['cpf_numero']; ?>, domiciliado(a) na <?php echo $contrato['endereco_cliente']; ?>, Cep. <?php echo $contrato['cep']; ?>, adiante denominado ARRENDATÁRIO, têm entre si justo e contratado o que se segue:
    </p>

    <p>
        1.0 O ARRENDADOR é senhor e legítimo proprietário da <?php echo $contrato['nome_propriedade']; ?>, situado na <?php echo $contrato['endereco_propriedade']; ?>, nesta cidade, pelo que, através do presente contrato, ARRENDA ao segundo nominada, aqui chamada ARRENDATÁRIO.
    </p>

    <p>
        2.0 O prazo de arrendamento é de <?php echo $tempo; ?>, de <?php echo date('d/m/Y', strtotime($contrato['data_inicio_residencia'])); ?> a <?php echo date('d/m/Y', strtotime($contrato['data_final_residencia'])); ?>. Ao final do contrato, o ARRENDATÁRIO se obriga a entregar o imóvel arrendado completamente desocupado e em perfeitas condições de higiene e uso para o ARRENDADOR.
    </p>

    <p>
        3.0 O valor mensal do arrendamento, durante todo o período, será de <?php echo ' R$ ' . number_format($contrato['valor_aluguel'], 2, ',', '.'); ?>
        (<?php echo $valorPorExtenso; ?>), que será pago todo o dia <?php echo $dataFormatadaDia; ?> de cada mês, na forma de cheques pré-datados, sendo o primeiro para o dia <?php echo $dataFormatada; ?> e o último para o dia <?php echo $dataFormatada; ?>.
    </p>

    <p>
        4.0 O ARRENDATÁRIO não poderá ceder ou transferir o presente contrato, total ou parcialmente, a terceiros, sem a autorização expressa do ARRENDADOR.
    </p>

    <p>
        5.0 O não pagamento, na data aprazada, do arrendamento, por parte do ARRENDATÁRIO, implicará na cobrança da multa de 10% (dez por cento) sobre o valor do arrendamento em atraso.
    </p>

    <p>
        6.0 O ARRENDATÁRIO, se compromete a utilizar o imóvel arrendado de maneira responsável, respeitando as normas de vizinhança, e, em caso de danos causados ao imóvel, será responsabilizado por repará-los ou indenizá-los.
    </p>

    <div class="signature">
        <p>__________________________</p>
        <p>Arnaldo Dardis Júnior</p>
        <p>ARRENDADOR</p>
        <p>__________________________</p>
        <p><?php echo $contrato['nome_cliente']; ?></p>
        <p>ARRENDATÁRIO</p>
    </div>
</body>

</html>
