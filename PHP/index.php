<?php

include('./conexao.php');
include('./model/cep.php');

$cep = $_GET['cep'];

$cepModel = new CEP();

//verifica se o cep tem registro no banco
$cepExists = $cepModel->getCep($cep);

if ($cepExists != false) {
    echo json_encode($cepExists);
} else {
    $url = "https://viacep.com.br/ws/" . $cep . "/xml/";

    $responseRequest = $cepModel->requestHttp($url);
    $responseXml = new SimpleXMLElement($responseRequest);

    $paramters = array(
        'cep' => $cep,
        'rua' => strval($responseXml->logradouro),
        'bairro' => strval($responseXml->bairro),
        'cidade' => strval($responseXml->localidade),
        'uf' => strval($responseXml->uf),
        'complemento' => strval($responseXml->complemento)
    );

    $resultInsert = $cepModel->insertCep($paramters);
    
    echo json_encode($paramters);
}
