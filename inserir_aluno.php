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
     echo "<h1>$usuario_logado</h1><br>";
    //função para quando o botão for clicado
    function logout(){
        session_destroy();
        header("Location: login.php");
    }
    if(isset($_POST['sair'])){
        logout();
    }

    if(!empty($_POST['txt_nome_aluno'])){
        if(!empty($_POST['txt_senha_aluno'])){
            if(!empty($_POST['txt_nota_bimestre01'])){
                if(!empty($_POST['txt_nota_bimestre01'])){
                    if(!empty($_POST['txt_nota_bimestre01'])){
                        if(!empty($_POST['txt_nota_bimestre01'])){
                            $nome_aluno = $_POST['txt_nome_aluno'];
                                $senha_aluno = $_POST['txt_senha_aluno'];
                                $nota_bimestre01 = $_POST['txt_nota_bimestre01'];
                                $nota_bimestre02 = $_POST['txt_nota_bimestre02'];
                                $nota_bimestre03 = $_POST['txt_nota_bimestre03'];
                                $nota_bimestre04 = $_POST['txt_nota_bimestre04'];
                                $nota_final = ($nota_bimestre01 + $nota_bimestre02 + $nota_bimestre03 + $nota_bimestre04)/4;
                                try{
                                    $sql_insert = "INSERT INTO alunos (nome, nota_bimestre_01, nota_bimestre_02, nota_bimestre_03, nota_bimestre_04, nota_final, senha) VALUES(?, ?, ?, ?, ?, ?, ?);";
                                    // sql preparada para evitar sql injection, passa a string depois passa o parametro pelo metodo bind_param. Dentro do metodo é nessecario passar os tipos dos parametros 's'->string, 'd'->double, 'i'->int, 'b'->boolean
                                    $sql_preparada = $con->prepare($sql_insert);
                                    $sql_preparada->bind_param("sddddds", $nome_aluno, $nota_bimestre01, $nota_bimestre02, $nota_bimestre03, $nota_bimestre04, $nota_final, $senha_aluno);
                                    $sql_preparada->execute();
                                }catch(Exception $e){
                                    echo "Erro ao salvar $e";
                                }
                        }else{
                            echo "Necessario digitar a nota do quarto bimestre do aluno";
                        }
                    }else{
                        echo "Necessario digitar a nota do terceiro bimestre do aluno";
                    }
                }else{
                    echo "Necessario digitar a nota do segundo bimestre do aluno";
                }
            }else{
                echo "Necessario digitar a nota do primeiro bimestre do aluno";
            }
        }else{
            echo "Necessario digitar a senha do aluno";
        }
    }else{
        echo "Necessario digitar o nome do aluno";
    }


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo_boletim.css">
    <title>Secretaria</title>
</head>
<body>
    <form action="" method="post">
        <input type="submit" value="Sair" name="sair">
    </form>
    <form action="" method="post" class="form" id="form_inserir_aluno">
        <label for="txt_nome_aluno">Nome do aluno</label>
        <input type="text" name="txt_nome_aluno" id="txt_nome_aluno">
        <label for="txt_senha_aluno">Senha provisoria do aluno</label>
        <input type="text" name="txt_senha_aluno" id="txt_senha_aluno">
        <label for="txt_nota_bimestre01">Nota do primeiro bimestre</label>
        <input type="number" name="txt_nota_bimestre01" id="txt_nota_bimestre01">
        <label for="txt_nota_bimestre02">Nota do segundo bimestre</label>
        <input type="number" name="txt_nota_bimestre02" id="txt_nota_bimestre02">
        <label for="txt_nota_bimestre03">Nota do terceiro bimestre</label>
        <input type="number" name="txt_nota_bimestre03" id="txt_nota_bimestre03">
        <label for="txt_nota_bimestre04">Nota do quarto bimestre</label>
        <input type="number" name="txt_nota_bimestre04" id="txt_nota_bimestre04">
        <input type="reset" value="Limpar">
        <input type="submit" value="Salvar">
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