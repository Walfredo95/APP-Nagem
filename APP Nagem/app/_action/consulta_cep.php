<?php

require_once __DIR__."/force_login.php";

function webClient($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
$cep = $_POST["cep"];
$cep = str_replace("-","",$cep);

$url = "http://viacep.com.br/ws/$cep/json/";
$result = json_decode(webClient($url));

if(empty($result)){
    echo 'ERRO';
    exit();
}
echo json_encode($result);

exit();