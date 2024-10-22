<?php
$url = 'https://client-api.debit.com.br/atualiza-v1/lerTabela';
$data = [
    'tabela' => 'igpm',
    'apikey' => '762c351f-a46c-4a9e-ab35-3fee21bad80a'
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);

$response = curl_exec($ch);

if ($response === false) {
    echo 'Erro: ' . curl_error($ch);
} else {
    // Converte a resposta JSON para um array associativo
    $data = json_decode($response, true);

    // Exibe a resposta para inspecionar onde estão os valores do IGPM
    print_r($data);

    // Adicione esta parte aqui para acessar e exibir o valor do IGPM
    $valor_igpm = $data['nome_chave_do_igpm']; // Substitua pelo nome correto encontrado na resposta
    echo "Valor IGPM: " . $valor_igpm;
}

curl_close($ch);
?>
