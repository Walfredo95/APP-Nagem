<?php
session_start();
date_default_timezone_set("America/Belem");
function senhaIncorreta()
{
?>
    <script>
        M.toast({
            html: "<strong class='red-text'>Login ou senha Incorretos</strong>"
        })
    </script>
<?php
}

if (empty($_POST["login"]) || empty($_POST["senha"])) {
    exit();
}

require_once __DIR__ . "/../connections/db_connect.php";

$login = mysqli_escape_string($conn, $_POST["login"]);
$senha = mysqli_escape_string($conn, $_POST["senha"]);

$sql = "SELECT * FROM tbl_login WHERE login = '$login'";

$result = mysqli_query($conn, $sql);

if ($result->num_rows == 0) {
    mysqli_close($conn);
    senhaIncorreta();
    exit();
}

$result = mysqli_fetch_assoc($result);

if ($result["senha"] == md5($senha)) {
    $_SESSION["login"]["logged"] = true;
    $_SESSION["login"]["login"] = $login;
    $_SESSION["login"]["hora"] = date("d/m/y h:i:s");

?>
    <script>
        location.replace("/app/index.php")
    </script>
<?php
} else {
    senhaIncorreta();
}
mysqli_close($conn);
exit();
