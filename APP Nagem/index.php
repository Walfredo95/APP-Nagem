<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="/materialize/css/materialize.min.css">
    <script src="/materialize/js/materialize.min.js"></script>
    <script src="/js/jquery.js"></script>

    <style>

    </style>
</head>

<body>
    <div class="container">
        <div style="margin-top: 10%;" align='center'>
            <h4>LOGIN</h4>
        </div>
        <div class="card-panel" style="width: 60%;margin-left:20%;">
            <div class="row">
                <div class="input-field col s6 offset-s3">
                    <input type="text" name="login" id="login">
                    <label for="login">LOGIN</label>
                </div>
            </div>
            <div class="row" style="margin-top: -5%;">
                <div class="input-field col s6 offset-s3">
                    <input type="password" name="senha" id="senha">
                    <label for="senha">SENHA</label>
                </div>
            </div>
            <div align='center'>
                <button id="btn-login" style="width: 30%;" class="btn btn-light waves-effect">Login</button>
            </div>
        </div>
    </div>
    <div id="toast"></div>
</body>

<script>
    $("#btn-login").on("click", function() {
        var varLogin = $("#login").val()
        var varSenha = $("#senha").val()

        $.ajax({
            method: "POST",
            url: "/_action/send_login.php",
            data: {
                login: varLogin,
                senha: varSenha,
            },

            success: function(data) {
                $("#toast").html(data)
            },
        })
    });
</script>

</html>