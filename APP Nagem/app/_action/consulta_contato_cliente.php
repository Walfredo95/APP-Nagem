<?php
require_once __DIR__ . "/force_login.php";
require_once __DIR__ . "/../../connections/db_connect.php";

if (!isset($_POST["cliente_contato"])) {
    exit();
}
$cliente_contato = mysqli_escape_string($conn, $_POST["cliente_contato"]);
$sql = "SELECT * FROM tbl_contatos WHERE id_cliente = '$cliente_contato'";

$result_sql = mysqli_query($conn, $sql);

?>
<select required name="contato" id="contato">
    <option selected disabled value="">Selecione um contato...</option>
    <?php
    while ($row = mysqli_fetch_assoc($result_sql)) {
        ?><option value="<?php echo $row["id"] ?>"><?php echo $row["nome_contato"] ?></option><?php
    }
    ?>
</select>
<label for="contato">Contato</label> </div>
<?php
mysqli_close($conn);
exit();