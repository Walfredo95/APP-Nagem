<?php
require_once __DIR__ . "/force_login.php";
require_once __DIR__ . "/../../connections/db_connect.php";

if (!isset($_POST["tipo"])) {
    header("location: /app/");
    mysqli_close($conn);
    exit();
}

$tipo = $_POST["tipo"];

switch ($tipo) {
    case "cliente":
        if (!isset($_POST["cliente"])) {
            header("location: /app/");
            mysqli_close($conn);
            exit();
        }

        $cliente = mysqli_escape_string($conn, $_POST["cliente"]);

        $sql = "SELECT * FROM tbl_clientes WHERE id = '$cliente'";

        $result = mysqli_query($conn, $sql);

        if ($result->num_rows == 0) {
            $_SESSION["mensagem"] = "<strong class='red-text'>Cliente não encontrado, tente novamente</strong>";
            header("location: /app/");
            mysqli_close($conn);
            exit();
        }

        $result = mysqli_fetch_assoc($result);


?>
            <div class="row">
                <div class="input-field col s6"> <input type="text" name="nome" id="nome" value="<?php echo $result["nome"] ?>"> <label class="active" for="nome">NOME</label> </div>
                <div class="input-field col s6"> <input type="text" name="CNPJ" id="CNPJ" value="<?php echo $result["cnpj"] ?>"> <label class="active" for="cnpj">CNPJ</label> </div>
            </div>
            <div class="row">
                <div class="input-field col s3"> <input required type="text" name="cep" id="cep" value="<?php echo $result["cep"] ?>"> <label class="active" for="cep">CEP</label> </div>
                <div class="input-field col s5"> <input readonly type="text" name="endereco" id="endereco" value="<?php echo $result["endereco"] ?>"> <label class="active" for="endereco">Endereço</label> </div>
                <div class="input-field col s4"> <input readonly type="text" name="bairro" id="bairro" value="<?php echo $result["bairro"] ?>"> <label class="active" for="bairro">Bairro</label> </div>
            </div>
            <div class="row">
                <div class="input-field col s3"> <input required type="text" name="numero" id="numero" value="<?php echo $result["numero"] ?>"> <label class="active" for="numero">Número</label> </div>
                <div class="input-field col s6"> <input readonly type="text" name="cidade" id="cidade" value="<?php echo $result["cidade"] ?>"> <label class="active" for= "cidade">Cidade</label> </div>
                <div class="input-field col s3"> <input readonly type="text" name="estado" id="estado" value="<?php echo $result["estado"] ?>"> <label class="active" for="estado">Estado</label> </div>
            </div>
            <div class="row">
                <div class="input-field col s6 offset-s3"> <select required name="Status" id="Status">
                        <?php
                        if($result["status"] == 1){
                            ?>
                            <option selected value="1">Ativo</option>
                            <option value="0">Inativo</option>    <?php
                        }else{
                            ?>   
                        <option value="1">Ativo</option>
                        <option selected value="0">Inativo</option><?php
                    }
                    ?>
                    </select> <label for="status">Status</label> </div>
            </div>

<?php

        break;
    case "contato":
        break;
    default:
        exit();
}
