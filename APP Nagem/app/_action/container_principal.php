<?php

require_once __DIR__ . "/force_login.php";


function menuInicial()
{
    require_once __DIR__ . "/../../connections/db_connect.php";

    $sql = "SELECT nome, tbl_clientes.id, nome_contato, email_contato, telefone_contato, cpf FROM tbl_clientes LEFT JOIN tbl_contatos ON id_cliente = tbl_clientes.id ORDER BY tbl_clientes.id";

    $result = mysqli_query($conn, $sql);
    $ultima_empresa = "";

    while ($row = mysqli_fetch_assoc($result)) {
        if ($ultima_empresa != $row["id"]) {
            if ($ultima_empresa != "") {
?>
                </tbody>
                </table>
            <?php
            }
            ?>
            <table class="centered">
                <thead>
                    <tr>
                        <th style="font-size: 20px;" colspan="4"><?php echo $row["nome"] ?></th>
                    </tr>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>CPF</th>
                    </tr>
                </thead>
                <tbody>

                <?php
            }
                ?>
                <tr>
                    <td><?php echo $row["nome_contato"] ?></td>
                    <td><?php echo $row["email_contato"] ?></td>
                    <td><?php echo $row["telefone_contato"] ?></td>
                    <td><?php echo $row["cpf"] ?></td>
                </tr>
            <?php

            $ultima_empresa = $row["id"];
        }
            ?>
                </tbody>
            </table>
        <?php
        exit();
    }

    function menuCadastrar()
    {
        ?>
            <div class="container">
                <div class="card-panel">
                    <div class="row">
                        <div class="input-field col s3">
                            <select name="tipo_cadastro" id="tipo_cadastro">
                                <option selected disabled value="">Selecione uma opção...</option>
                                <option value="cliente">Cliente</option>
                                <option value="contato">Contato</option>
                            </select>
                            <label for="tipo_cadastro">TIPO DE CADASTRO</label>
                        </div>
                    </div>
                    <div id="container_cadastro">
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $('select').formSelect();
                });

                $("#tipo_cadastro").on("change", function() {
                    tipo_cadastro = $("#tipo_cadastro :selected").val();

                    if (tipo_cadastro == "cliente") {
                        $("#container_cadastro").html('<form action="/app/_action/send_cadastro_cliente.php" method="POST"> <div class="row"> <div class="input-field col s6"> <input type="text" name="nome" id="nome"> <label for="nome">NOME</label> </div> <div class="input-field col s6"> <input type="text" name="CNPJ" id="CNPJ"> <label for="cnpj">CNPJ</label> </div> </div> <div class="row"> <div class="input-field col s3"> <input required type="text" name="cep" id="cep"> <label for="cep">CEP</label> </div> <div class="input-field col s5"> <input readonly type="text" name="endereco" id="endereco"> <label class="active" for="endereco">Endereço</label> </div> <div class="input-field col s4"> <input readonly type="text" name="bairro" id="bairro"> <label class="active" for="bairro">Bairro</label> </div> </div> <div class="row"> <div class="input-field col s3"> <input required type="text" name="numero" id="numero"> <label for="numero">Número</label> </div> <div class="input-field col s6"> <input readonly type="text" name="cidade" id="cidade"> <label class="active for="cidade">Cidade</label> </div> <div class="input-field col s3"> <input readonly type="text" name="estado" id="estado"> <label class="active" for="estado">Estado</label> </div> </div> <div class="row"> <div class="input-field col s6 offset-s3"> <select required name="Status" id="Status"> <option value="1">Ativo</option> <option value="0">Inativo</option> </select> <label for="status">Status</label> </div> </div> <div align="center"><button type="submit" class="btn btn-light waves-effect">Enviar</button></div></form>')
                        $("#CNPJ").mask("99.999.999/9999-99");
                        $("#cep").mask("99999-999");

                        $('select').formSelect();

                        $("#cep").on("change", function() {
                            var lengh = $("#cep").val().length

                            console.log(lengh)

                            if (lengh == 9) {
                                $.ajax({
                                    url: "/app/_action/consulta_cep.php",
                                    method: "POST",
                                    data: {
                                        cep: $("#cep").val()
                                    },

                                    success: function(data) {
                                        var result_cep = JSON.parse(data)
                                        if (result_cep["erro"] == true) {
                                            $("#cep").val("")
                                            M.toast({
                                                html: "<strong class='red-text'>CEP Inválido</strong>"
                                            })
                                        } else {
                                            $("#endereco").val(result_cep["logradouro"])
                                            $("#bairro").val(result_cep["bairro"])
                                            $("#cidade").val(result_cep["localidade"])
                                            $("#estado").val(result_cep["uf"])
                                            console.log(result_cep)

                                        }
                                    },
                                })
                            } else {
                                $("#cep").val("")
                                M.toast({
                                    html: "<strong class='red-text'>CEP Inválido</strong>"
                                })
                            }
                        })

                    } else if (tipo_cadastro == "contato") {
                        $("#container_cadastro").html('<form action="/app/_action/send_cadastro_contato.php" method="POST"> <div class="row"> <div class="input_field col s4"> <select required name="cliente" id="cliente"> <option selected disabled value="">Selecione um cliente...</option> <?php require_once __DIR__ . "/../../connections/db_connect.php"; $sql = "SELECT * FROM tbl_clientes ORDER BY nome"; $result_sql = mysqli_query($conn, $sql); while ($row = mysqli_fetch_assoc($result_sql)) { ?> <option value="<?php echo $row["id"] ?>"><?php echo $row["nome"] ?></option> <?php } ?> </select> <label for="cliente">Cliente</label> </div> </div> <div class="row"> <div class="input-field col s6"> <input required type="text" name="nome_contato" id="nome_contato"> <label for="nome_contato">Nome do Contato</label> </div> <div class="input-field col s6"> <input required type="email" name="email_contato" id="email_contato"> <label for="email_contato">Email do Contato</label> </div> </div> <div class="row"> <div class="input-field col s6"> <input required type="tel" name="telefone_contato" id="telefone_contato"> <label for="telefone_contato">Telefone do Contato</label> </div> <div class="input-field col s6"> <input required type="text" name="cpf_contato" id="cpf_contato"> <label for="cpf_contato">CPF do Contato</label> </div> </div> <div align="center"> <button type="submit" class="btn btn-light waves-effect">Enviar</button> </div> </form>');
                        $('select').formSelect();
                        
                        $('#email_contato').mask("A", {
                            translation: {
                                "A": { pattern: /[\w@\-.+]/, recursive: true }
                            }
                        });

                        $("#cpf_contato").mask('000.000.000-00', {reverse: true});

                        $('#telefone_contato').mask('(00) 0000-00009');
                        $('#telefone_contato').blur(function(event) {
                        if($(this).val().length == 15){
                            $(this).mask('(00) 00000-0009');
                        } else {
                            $(this).mask('(00) 0000-00009');
                        }
                        });

                    }
                })
            </script>
        <?php
    }

    function menuEditar()
    {
    }

    function menuDeletar()
    {
        ?>
            <div class="container">
                <div class="card-panel">
                    <div class="row">   
                        <div class="input-field col s3">
                            <select name="tipo_delete" id="tipo_delete">
                                <option selected disabled value="">Selecione uma opção...</option>
                                <option value="cliente">Cliente</option>
                                <option value="contato">Contato</option>
                            </select>
                            <label for="tipo_delete">TIPO DE EXCLUSÃO</label>
                        </div>
                    </div>
                    <div id="container_delete">
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $('select').formSelect();
                });

                $("#tipo_delete").on("change", function() {
                    tipo_delete = $("#tipo_delete :selected").val();

                    if (tipo_delete == "cliente") {
                        $("#container_delete").html('<form action="/app/_action/send_deletar_cliente.php" method="POST"> <div class="row"> <div class="input-field col s6"> <select required name="cliente" id="cliente"> <option selected disabled value="">Selecione um cliente...</option> <?php require_once __DIR__."/../../connections/db_connect.php"; $sql = "SELECT * FROM tbl_clientes ORDER BY nome"; $result_sql = mysqli_query($conn, $sql); while($row = mysqli_fetch_assoc($result_sql)){ ?> <option value="<?php echo $row["id"] ?>"><?php echo $row["nome"] ?></option> <?php } ?> </select> <label for="cliente">Cliente</label> </div> </div> <div align="center"> <button type="submit" class="btn btn-light red waves-effect">EXCLUIR</button> </div> </form>')
                        
                        $('select').formSelect();


                    } else if (tipo_delete == "contato") {
                        $("#container_delete").html('<form action="/app/_action/send_deletar_contato.php" method="POST"> <div class="row"> <div class="input-field col s6"> <select required name="cliente_contato" id="cliente_contato"> <option selected disabled value="">Selecione um cliente...</option> <?php require_once __DIR__ . "/../../connections/db_connect.php"; $sql = "SELECT * FROM tbl_clientes ORDER BY nome"; $result_sql = mysqli_query($conn, $sql); while ($row = mysqli_fetch_assoc($result_sql)) { ?> <option value="<?php echo $row["id"] ?>"><?php echo $row["nome"] ?></option> <?php } ?> </select> <label for="cliente_contato">Cliente</label> </div> <div id="listagem_cliente" class="input-field col s6"></div></div> <div align="center"> <button type="submit" class="btn btn-light red waves-effect">EXCLUIR</button> </div> </form>')
                        $('select').formSelect();
                        $("#cliente_contato").on("change", function() {
                            $.ajax({
                                url: "/app/_action/consulta_contato_cliente.php",
                                method: "POST",
                                data: {
                                    cliente_contato: $("#cliente_contato :selected").val()
                                },

                                success: function(data) {
                                    $("#listagem_cliente").html(data)
                                    $('select').formSelect();
                                },
                            })
                        });
                    }
                })

                
            </script>
        <?php
    }

    # OPÇÕES PARA O CONTAINER PRINCIPAL #

    if (!isset($_GET["opcao"]))
        exit();

    $opcao = $_GET["opcao"];

    switch ($opcao) {
        case "cadastrar":
            menuCadastrar();
            break;
        case "inicio":
            menuInicial();
            break;
        case "editar":
            menuEditar();
            break;
        case "deletar":
            menuDeletar();
            break;
        default:
            exit();
    }
