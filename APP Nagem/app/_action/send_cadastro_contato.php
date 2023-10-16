<?php
require_once __DIR__ . "/force_login.php";
require_once __DIR__ . "/../../connections/db_connect.php";

if (!isset($_POST["cliente"]) || !isset($_POST["nome_contato"]) || !isset($_POST["email_contato"]) || !isset($_POST["telefone_contato"]) || !isset($_POST["cpf_contato"])) {
    $_SESSION["mensagem"] = "<strong class='red-text'>Todos os campos precisam estar preenchidos para o cadastro</strong>";
    header("location: /app/");
    mysqli_close($conn);
    exit();
}

function validaCPF($cpf)
{

    // Extrai somente os números
    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}

$id_cliente = mysqli_escape_string($conn, $_POST["cliente"]);
$nome_contato = mysqli_escape_string($conn, $_POST["nome_contato"]);
$email_contato = mysqli_escape_string($conn, $_POST["email_contato"]);
$telefone_contato = mysqli_escape_string($conn, $_POST["telefone_contato"]);
$cpf_contato = mysqli_escape_string($conn, $_POST["cpf_contato"]);
$cpf_contato = str_replace([".","-"], "", $cpf_contato);

if(validaCPF($cpf_contato) == false){
    $_SESSION["mensagem"] = "<strong class='red-text'>O CPF Informado é inválido</strong>";
    header("location: /app/");
    mysqli_close($conn);
    exit();
}

$sql = "SELECT * FROM tbl_contatos INNER JOIN tbl_clientes ON id_cliente = tbl_clientes.id WHERE email_contato = '$email_contato' AND status = '1'";
$result_sql = mysqli_query($conn, $sql);

if($result_sql->num_rows != 0){
    $_SESSION["mensagem"] = "<strong class='red-text'>O Email Informado já está vinculado em outro cliente</strong>";
    header("location: /app/");
    mysqli_close($conn);
    exit();
}

$sql = "SELECT * FROM tbl_contatos INNER JOIN tbl_clientes ON id_cliente = tbl_clientes.id WHERE telefone_contato = '$telefone_contato' AND status = '1'";
$result_sql = mysqli_query($conn, $sql);

if($result_sql->num_rows != 0){
    $_SESSION["mensagem"] = "<strong class='red-text'>O Telefone Informado já está vinculado em outro cliente</strong>";
    header("location: /app/");
    mysqli_close($conn);
    exit();
}

$sql = "SELECT * FROM tbl_contatos INNER JOIN tbl_clientes ON id_cliente = tbl_clientes.id WHERE cpf = '$cpf_contato' AND status = '1'";
$result_sql = mysqli_query($conn, $sql);

if($result_sql->num_rows != 0){
    $_SESSION["mensagem"] = "<strong class='red-text'>O CPF Informado já está vinculado em outro cliente</strong>";
    header("location: /app/");
    mysqli_close($conn);
    exit();
}

$sql = "INSERT INTO tbl_contatos (id_cliente, nome_contato, email_contato, telefone_contato, cpf) VALUES ('$id_cliente', '$nome_contato', '$email_contato', '$telefone_contato', '$cpf_contato')";

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