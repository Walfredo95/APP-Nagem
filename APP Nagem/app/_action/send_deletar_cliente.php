<?php
require_once __DIR__ . "/force_login.php";
require_once __DIR__ . "/../../connections/db_connect.php";

if (!isset($_POST["cliente"])) {
    $_SESSION["mensagem"] = "<strong class='red-text'>Não foi informado nenhum cliente para a deleção</strong>";
    header("location: /app/");
    mysqli_close($conn);
    exit();
}

$cliente = mysqli_escape_string($conn, $_POST["cliente"]);

$sql_contato = "DELETE FROM tbl_contatos WHERE id_cliente = '$cliente'";

if (mysqli_query($conn, $sql_contato)) {
    $sql_cliente = "DELETE FROM tbl_clientes WHERE id = '$cliente'";
    if(mysqli_query($conn, $sql_cliente)){
        $_SESSION["mensagem"] = "<strong class='green-text'>Cliente e contatos deletados com sucesso</strong>";
    }else{
        $_SESSION["mensagem"] = "<strong class='red-text'>Ocorreu um erro ao deletar o cliente, tente novamente</strong>";
    }
} else {
    $_SESSION["mensagem"] = "<strong class='red-text'>Ocorreu um erro ao deletar os contatos do cliente, tente novamente</strong>";
}
header("location: /app/");
mysqli_close($conn);
exit();