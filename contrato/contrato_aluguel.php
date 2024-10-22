<?php
require_once "../conexao/conexao.php";

    // Prepara a consulta SQL
    $sql = "SELECT 
    contratos.*,
    propriedade.nome_propriedade,
    propriedade.endereco AS endereco_propriedade,
    inquilino.nome_inquilino,
    inquilino.rg_numero,
    inquilino.cpf_numero,
    inquilino.profissao,
    inquilino.nacionalidade,
    inquilino.cep,
    inquilino.endereco AS endereco_inquilino
FROM contratos
JOIN propriedade ON contratos.id_propriedade = propriedade.idpropriedade
JOIN inquilino ON contratos.id_inquilino = inquilino.idinquilino
WHERE contratos.id_contrato = 2";


    $result = $conn->query($sql);
        $contrato = $result->fetch_assoc();

        // Formatação da data
$vencimento = new DateTime($contrato['vencimento']);
$dataFormatada = $vencimento->format('d/m/Y');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Locação de Imóvel</title>
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
    <h1>CONTRATO DE LOCAÇÃO DE IMÓVEL COMERCIAL</h1>

    <p>
        Pelo presente instrumento, ARNALDO DARDIS JÚNIOR, brasileiro, empresário, casado, RG n. 9 1171848-SSP/PB, CPF/MF n. 9 552.496.044-04, domiciliado na Rua Governador Antonio Mariz, nº 600, Bairro Portal do Sol, nesta cidade, adiante denominado LOCADOR; 
        e <?php echo $contrato['nome_inquilino']; ?>, <?php echo $contrato['nacionalidade']; ?>, RG nº <?php echo $contrato['rg_numero']; ?>, CPF/MF nº <?php echo $contrato['cpf_numero']; ?>, domiciliado(a) na <?php echo $contrato['endereco_inquilino']; ?>, Cep. <?php echo $contrato['cep']; ?>, adiante denominada LOCATÁRIO(A), têm entre si justo e contratado o que se segue:
    </p>

    <p>
        1.0 O LOCADOR é senhor e legítimo proprietário da <?php echo $contrato['nome_propriedade']; ?>, situado na <?php echo $contrato['endereco_propriedade']; ?>, nesta cidade, pelo que, através do presente contrato, LOCA-A o segundo nominada, aqui chamada LOCATÁRIA.
    </p>

    <p>
        2.0 O prazo de locação é de 01 (um) ano, de 30 de novembro de 2017 a 30 de novembro de 2018. Ao final do contrato, a LOCATÁRIA se obriga a entregar o imóvel locado completamente desocupado e em perfeitas condições de higiene e uso para o LOCADOR.
    </p>

    <p>
        3.0 O valor mensal do aluguel, durante todo o período, será de <?php echo ' R$ ' . number_format($contrato['valor_aluguel'], 2, ',', '.'); ?>
        (Valor por extenso), que será pago todo o dia <?php echo $dataFormatada; ?> de cada mês, na forma de cheques pré-datados, sendo o primeiro para o dia <?php echo $dataFormatada; ?> e o último para o dia <?php echo $dataFormatada; ?>.
    </p>

    <p>
        4.0 O não pagamento do aluguel no prazo estipulado pelo item 3.0 implicará em multa de 2% (dois por cento) sobre o valor do débito, juros de 1% (um por cento) ao mês e correção monetária calculada pelo IGP-M.
    </p>

    <p>
        5.0 Havendo inadimplência da LOCATÁRIA por mais de 30 (trinta) dias corridos, considerar-se-á rescindido o presente contrato de locação, independentemente de notificação, seja judicial ou extrajudicial, sem prejuízos dos encargos previstos pelo item 4.0 deste instrumento.
    </p>

    <p>
        6.0 Obriga-se a LOCATÁRIA a pagar, durante todo o período da locação, as respectivas contas de energia, água, prêmio de seguro contra incêndio e as taxas de condomínio da loja, bem como o IPTU e a taxa de lixo, cabendo-lhe efetuar diretamente esses pagamentos nas devidas épocas.
    </p>

    <p>
        7.0 A LOCATÁRIA, salvo as obras que importem em segurança do imóvel, obriga-se por todas as outras, devendo restituir o imóvel locado em boas condições de higiene e limpeza.
    </p>

    <p>
        8.0 A LOCATÁRIA, dentro de quarenta dias da assinatura deste instrumento, fica obrigada a transferir a conta de energia para o seu nome, ou de empresa a ser constituída por ela e sediada no imóvel ora locado.
    </p>

    <p>
        9.0 Benfeitorias. Eventuais reformas ou adaptações que a LOCATÁRIA pretenda executar no imóvel só poderão ser realizadas mediante autorização prévia e expressa do LOCADOR. Eventuais benfeitorias ficam incorporadas ao imóvel, não cabendo à LOCATÁRIA qualquer direito de indenização ou retenção.
    </p>

    <p>
        10.0 Obriga-se a LOCATÁRIA a satisfazer a todas as exigências dos poderes públicos a que der causa. A LOCATÁRIA não poderá transferir este contrato ou sublocar o imóvel no todo ou em parte, sem prévia autorização por escrito do LOCADOR.
    </p>

    <p>
        11.0 A LOCATÁRIA, desde já, faculta ao LOCADOR examinar ou vistoriar o imóvel, sempre que a segunda entender conveniente, desde que previamente acordados dia e hora. A LOCATÁRIA declara haver recebido o imóvel em perfeitas condições.
    </p>

    <p>
        12.0 A LOCATÁRIA, caso resolva entregar o imóvel antes de completar o primeiro ano de locação ou diante da hipótese do item 5.0, deverá pagar ao LOCADOR uma multa equivalente a 01 (um) aluguel em vigor, reduzida proporcionalmente ao tempo do contrato já cumprido.
    </p>

    <p>
        13.0 Esse contrato poderá ser renovado por períodos iguais, a cada um ano de vigência, desde que não haja qualquer notificação em contrário de qualquer uma das partes e com a antecedência mínima de sessenta dias do término de cada prazo contratual. Renovado o contrato, o valor do aluguel será reajustado anualmente pelo IGP-M.
    </p>

    <p>
        14.0 A LOCATÁRIA, nesta data, declara ter recebido uma cópia do Regimento Interno e da respectiva Convenção de Condomínio, obrigando-se a cumpri-las fielmente.
    </p>

    <p>
        15.0 As partes contratantes elegem, nesta ocasião, para dirimir qualquer dúvida acerca do presente contrato, o foro da situação do imóvel, renunciando a qualquer outro.
    </p>

    <p>
        16.0 E, por estarem justos e contratados, as partes assinam o presente instrumento, em 02 (duas) vias de igual teor e forma, na presença de 02 (duas) testemunhas, para que surta seus jurídicos e legais efeitos.
    </p>

    <p>
        João Pessoa (PB), 20 de março de 2018.
    </p>

    <div class="signature">
        <p>LOCADOR:</p>
        <p>_______________________________</p>
        <p>ARNALDO DARDIS JÚNIOR</p>
        <br>
        <p>LOCATÁRIO(A):</p>
        <p>_______________________________</p>
        <p><?php echo $contrato['nome_inquilino']; ?></p>
        <br>
        <p>TESTEMUNHAS:</p>
        <p>_______________________________</p>
        <p>_______________________________</p>
    </div>
</body>

</html>
