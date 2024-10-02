<?php
    include('conexao.php');
    $sql = "SELECT * FROM alunos";
    $dados = $con->query($sql);
    if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_SESSION['nome'])){
        //matar a pagina
        die(header("Location: login.php"));
    }
    $usuario_logado = $_SESSION['nome'];
    echo "<h1>$usuario_logado<h1/><br>";
    //função para quando o botão for clicado
    function logout(){
        session_destroy();
        header("Location: login.php");
    }
    if(isset($_POST['sair'])){
        logout();
    }


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secretaria</title>
</head>
<body>
    <form action="" method="post">
        <input type="submit" value="Sair" name="sair">
    </form>
    <table border="3px" class="tabela_alunos">
        <thead>
            <th>Nome</th>
            <th>Nota no primeiro Bimestre</th>
            <th>Nota no segundo Bimestre</th>
            <th>Nota no terceiro Bimestre</th>
            <th>Nota no quarto Bimestre</th>
        </thead>
        <tbody>
            <?php
            while($row = $dados->fetch_assoc()){
                $nome = $row['nome'];
                $nota_bimestre1 = $row['nota_bimestre_01'];
                $nota_bimestre2 = $row['nota_bimestre_02'];
                $nota_bimestre3 = $row['nota_bimestre_03'];
                $nota_bimestre4 = $row['nota_bimestre_04'];
                echo "<tr>
                        <td>$nome</td>
                        <td>$nota_bimestre1</td>
                        <td>$nota_bimestre2</td>
                        <td>$nota_bimestre3</td>
                        <td>$nota_bimestre4</td>
                    </tr>";
            }
            ?>
            
        </tbody>
    </table>
</body>
</html>