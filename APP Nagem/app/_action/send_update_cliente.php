<?php

require_once __DIR__ . "/force_login.php";
require_once __DIR__ . "/../../connections/db_connect.php";

if (!isset($_POST["cliente"]) || !isset($_POST["nome"]) || !isset($_POST["CNPJ"]) || !isset($_POST["cep"]) || !isset($_POST["endereco"]) || !isset($_POST["bairro"]) || !isset($_POST["numero"]) || !isset($_POST["cidade"]) || !isset($_POST["estado"]) || !isset($_POST["Status"])) {
    $_SESSION["mensagem"] = "<strong class='red-text'>Todos os campos precisam estar preenchidos para o cadastro</strong>";
    header("location: /app/");
    mysqli_close($conn);
    exit();
}

$cliente = mysqli_escape_string($conn, $_POST["cliente"]);
$nome = mysqli_escape_string($conn, $_POST["nome"]);
$cnpj = mysqli_escape_string($conn, $_POST["CNPJ"]);
$cnpj = str_replace([".", "/", "-"], "", $cnpj);
$cep = mysqli_escape_string($conn, $_POST["cep"]);
$cep = str_replace("-", "", $cep);
$endereco = mysqli_escape_string($conn, $_POST["endereco"]);
$bairro = mysqli_escape_string($conn, $_POST["bairro"]);
$numero = mysqli_escape_string($conn, $_POST["numero"]);
$cidade = mysqli_escape_string($conn, $_POST["cidade"]);
$estado = mysqli_escape_string($conn, $_POST["estado"]);
$status = mysqli_escape_string($conn, $_POST["Status"]);

$sql = "UPDATE tbl_clientes SET nome = '$nome', cnpj = '$cnpj', cep = '$cep', endereco = '$endereco', numero = '$numero', bairro = '$bairro', cidade = '$cidade', estado = '$estado', status = '$status' WHERE id = '$cliente'";

if(mysqli_query($conn, $sql)){
    $_SESSION["mensagem"] = "<strong class='green-text'>Cliente atualizado com sucesso</strong>";
}else{
    $_SESSION["mensagem"] = "<strong class='red-text'>Ocorreu um erro ao atualizar o cliente</strong>";
}
mysqli_close($conn);
header("location: /app/");
exit();