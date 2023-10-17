<?php
require_once __DIR__ . "/force_login.php";
require_once __DIR__ . "/../../connections/db_connect.php";

if (!isset($_POST["cliente_contato"]) || !isset($_POST["contato"])) {
    $_SESSION["mensagem"] = "<strong class='red-text'>Não foi informado nenhum contato ou cliente para a deleção</strong>";
    header("location: /app/");
    mysqli_close($conn);
    exit();
}

$cliente = mysqli_escape_string($conn, $_POST["cliente_contato"]);
$contato = mysqli_escape_string($conn, $_POST["contato"]);

$sql_contato = "DELETE FROM tbl_contatos WHERE id = '$contato'";

if (mysqli_query($conn, $sql_contato)) {
    $_SESSION["mensagem"] = "<strong class='green-text'>Contato deletado com sucesso</strong>";
} else {
    $_SESSION["mensagem"] = "<strong class='red-text'>Ocorreu um erro ao deletar o contato, tente novamente</strong>";
}
header("location: /app/");
mysqli_close($conn);
exit();