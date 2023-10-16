<?php

require_once __DIR__ . "/headers/header.php";

?>
<title>Página Inicial</title>

<body>

    <?php
    if (isset($_SESSION["mensagem"])) {
    $mensagem = $_SESSION["mensagem"];
    ?>
    <script>
        M.toast({
            html: "<?php echo $mensagem ?>"
        })
    </script>
    <?php
    unset($_SESSION["mensagem"]);
    }
    ?>

    <nav>
        <div class="nav-wrapper grey">
            <a href="/_action/logout.php" class="brand-logo right">Sair</a>
            <ul id="nav-mobile" class="left hide-on-med-and-down">
                <li><a onclick="menu('inicio')" id="inicio">Início</a></li>
                <li><a onclick="menu('cadastrar')" id="cadastrar">Cadastrar</a></li>
                <li><a onclick="menu('editar')" id="editar">Editar</a></li>
                <li><a onclick="menu('deletar')" id="deletar">Deletar</a></li>
            </ul>
        </div>
    </nav>

    <div id="container_principal"></div>
</body>

<script>
    function menu(varOpcao) {

        $.ajax({
            url: "/app/_action/container_principal.php",
            method: "GET",
            data: {
                opcao: varOpcao
            },

            beforeSend: function() {
                $("#container_principal").html("Carregando...");
            },

            success: function(data) {
                $("#container_principal").html(data)
            },

            error: function() {
                $("#container_principal").html("Opção inválida");
            }
        })

    }
</script>

</html>