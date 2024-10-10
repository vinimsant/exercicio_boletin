<?php
    include('conexao.php');
    $sql = "SELECT * FROM notas_alunos";
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

    if(isset($_POST['salvar_aluno'])){
        $nome_aluno = $_POST['txt_nome_aluno'];
        $senha_aluno = $_POST['txt_senha_aluno'];
        $nota_bimestre01 = $_POST['txt_nota_bimestre01'];
        $nota_bimestre02 = $_POST['txt_nota_bimestre02'];
        $nota_bimestre03 = $_POST['txt_nota_bimestre03'];
        $nota_bimestre04 = $_POST['txt_nota_bimestre04'];
        $cpf = $_POST['txt_cpf'];
        $privilegios = "aluno";
        $nota_final = ($nota_bimestre01 + $nota_bimestre02 + $nota_bimestre03 + $nota_bimestre04)/4;
        try{
            //inserir na tabela notas dos alunos
            $sql_insert = "INSERT INTO notas_alunos (nome, nota_bimestre_01, nota_bimestre_02, nota_bimestre_03, nota_bimestre_04, nota_final, senha, id) VALUES(?, ?, ?, ?, ?, ?, ?, ?);";
    
            //inserir na tabela usuarios
            $sql_insert_usuario = "INSERT INTO usuarios (id, nome, senha, privilegios) VALUES (?, ?, ?, ?)";
            // sql preparada para evitar sql injection, passa a string depois passa o parametro pelo metodo bind_param. Dentro do metodo é nessecario passar os tipos dos parametros 's'->string, 'd'->double, 'i'->int, 'b'->boolean
            $sql_preparada1 = $con->prepare($sql_insert_usuario);
            $sql_preparada1->bind_param("isss", $cpf, $nome_aluno, $senha_aluno, $privilegios);
            $sql_preparada1->execute();
            $sql_preparada = $con->prepare($sql_insert);
            $sql_preparada->bind_param("sdddddsi", $nome_aluno, $nota_bimestre01, $nota_bimestre02, $nota_bimestre03, $nota_bimestre04, $nota_final, $senha_aluno, $cpf);
            $sql_preparada->execute();
            //codigo para atualizar a pagina
            header("Refresh: 0");
        }catch(Exception $e){
            echo "Erro ao salvar $e";
        }
    
    }

    //botão vizualizar
    if(isset($_POST['btn_visualizar'])){
        $_SESSION['id_aluno'] = $_POST['id'];
        $_SESSION['nome_aluno'] = $_POST['nome'];
        header("Location: boletin.php");
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
    <div class="centralizar_inserir">
        <form action="" method="post" class="form" id="form_inserir_aluno">
            <label for="txt_nome_aluno">Nome do aluno</label>
            <input type="text" name="txt_nome_aluno" id="txt_nome_aluno" required>
            <label for="txt_senha_aluno">Senha provisoria do aluno</label>
            <input type="text" name="txt_senha_aluno" id="txt_senha_aluno" required>
            <label for="txt_cpf">Digite o CPF do Aluno</label>
            <input type="text" name="txt_cpf" id="txt_cpf" maxlength="11" minlength="11" required>
            <label for="txt_nota_bimestre01">Nota do primeiro bimestre</label>
            <input type="number" name="txt_nota_bimestre01" id="txt_nota_bimestre01" required>
            <label for="txt_nota_bimestre02">Nota do segundo bimestre</label>
            <input type="number" name="txt_nota_bimestre02" id="txt_nota_bimestre02" required>
            <label for="txt_nota_bimestre03">Nota do terceiro bimestre</label>
            <input type="number" name="txt_nota_bimestre03" id="txt_nota_bimestre03" required>
            <label for="txt_nota_bimestre04">Nota do quarto bimestre</label>
            <input type="number" name="txt_nota_bimestre04" id="txt_nota_bimestre04" required>
            <input type="reset" value="Limpar">
            <input type="submit" value="Salvar" name="salvar_aluno">
        </form>
    </div>
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
                $id = $row['id'];
                $senha = $row['senha'];
                echo "<tr>
                        <td>$nome</td>
                        <td>$nota_bimestre1</td>
                        <td>$nota_bimestre2</td>
                        <td>$nota_bimestre3</td>
                        <td>$nota_bimestre4</td>";
                        ?>
                        <td>
                            <form action="" method="post">
                                <input type="text" name="id" value="<?php echo $id;?>" hidden>
                                <input type="text" name="nome" value="<?php echo $nome;?>" hidden>
                                <input type="submit" name="btn_visualizar" value="Visualizar">
                            </form>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="submit" name="btn_editar" value="Editar">
                            </form>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="submit" name="btn_excluir" value="Excluir">
                            </form>
                        </td>
                    </tr>";
            <?php        
            }
            ?>
        </tbody>
    </table>
    
</body>
</html>