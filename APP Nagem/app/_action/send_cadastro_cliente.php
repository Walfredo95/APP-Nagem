<?php

require_once __DIR__ . "/force_login.php";
require_once __DIR__ . "/../../connections/db_connect.php";

if (!isset($_POST["nome"]) || !isset($_POST["CNPJ"]) || !isset($_POST["cep"]) || !isset($_POST["endereco"]) || !isset($_POST["bairro"]) || !isset($_POST["numero"]) || !isset($_POST["cidade"]) || !isset($_POST["estado"]) || !isset($_POST["Status"])) {
    $_SESSION["mensagem"] = "<strong class='red-text'>Todos os campos precisam estar preenchidos para o cadastro</strong>";
    header("location: /app/");
    mysqli_close($conn);
    exit();
}

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

$sql = "SELECT * FROM tbl_clientes WHERE cnpj = '$cnpj'";
$result_sql = mysqli_query($conn, $sql);

if ($result_sql->num_rows != 0) {
    mysqli_close($conn);
    $_SESSION["mensagem"] = "<strong class='red-text'>O CNPJ informado já está cadastrado</strong>";
    header("location: /app/");
    exit();
}

$sql = "INSERT INTO tbl_clientes (nome, cnpj, endereco, numero, bairro, cidade, estado, cep, status) VALUES ('$nome', '$cnpj', '$endereco', '$numero', '$bairro', '$cidade', '$estado', '$cep', '$status')";

if (mysqli_query($conn, $sql)) {
    $_SESSION["mensagem"] = "<strong class='green-text'>Cliente cadastrado com sucesso</strong>";
} else {
    echo $sql;
    exit();
    $_SESSION["mensagem"] = "<strong class='red-text'>Ocorreu um erro ao cadastrar o cliente</strong>";
}

mysqli_close($conn);
header("location: /app/");
exit();
