<?php
include_once(conexa.php);
$email = "";
$senha = "";
if(!empty($_POST['txt_login'])&&!empty($_POST['txt_senha'])){
    $email = $_POST['txt_login'];
    $senha = $_POST['txt_senha'];
    $sql_busca = "select * from secretaria";
    $resut = $pdo->prepa
}else{

}


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <div class="formulario">
        <form action="login_secretaria.php" method="post">
            <label for="login">Digite seu Email</label>
            <input type="text" id="login" name="txt_login">
            <label for="senha">Digite sua senha</label>
            <input type="password" name="txt_senha" id="senha">
            <input type="reset" value="Limpar">
            <input type="submit" value="Enviar">
        </form>
    </div>
</body>
</html>