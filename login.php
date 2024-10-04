<?php
    include('conexao.php');
    
    if(!empty($_POST['txt_email'])&&!empty($_POST['txt_senha'])){
        $login = $_POST['txt_email'];
        $senha = $_POST['txt_senha'];
        
        $sql = "SELECT * FROM boletin.agentes_administrativos WHERE nome = '$login'";
        $dados = $con->query($sql);
        if ($dados->num_rows > 0) {
            
            while($row = $dados->fetch_assoc()) {
            // if para verificar se o nome e senha estão corretos
            if($login==$row['nome']&&$senha==$row['senha']){
                //if para verificar se já existe uma sessão
                if(!isset($_SESSION)){
                    session_start();
                }
                $_SESSION['id'] = $row['id'];
                $_SESSION['nome'] = $row['nome'];
                //verificar os privilegios para abrir a pagina adequada
                if($row['privilegios'] == 'administrativo'){
                    echo "usuario $login logado <br>";
                //função para redirecionar paginas
                header('Location: inserir_aluno.php');
                }else{
                    if($row['privilegios'] == 'aluno'){
                        $_SESSION['id'] = $row['id'];
                        $_SESSION['nome'] = $row['nome'];
                        header("Location: boletin.php");
                    }
                }
                

                
            }
            }
          } else {
            echo "Usuario ou senha incorretos";
          }
          $con->close();
        

        
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo_boletim.css">
    <title>Boletin Escolar</title>
</head>
<body>
    <div class="centralizar">
        <form action="login.php" method="post" class="form">
            <label for="email">Digite seu email</label>
            <input type="text" id="email" name="txt_email">
            <label for="senha">Digite a senha</label>
            <input type="password" id="senha" name="txt_senha">
            <input type="reset" value="Limpar">
            <input type="submit" value="Enviar">
        </form>
    </div>
</body>
</html>