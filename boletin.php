<?php
include("conexao.php");
if(!isset($_SESSION)){
    session_start();
}
if(!isset($_SESSION['nome'])){
    //matar a pagina
    die(header("Location: login.php"));
}
$usuario = $_SESSION['nome'];
$id_usuario_tb_agente_adminstrativo = $_SESSION['id'];
$sql = "SELECT * FROM alunos";
$dados = $con->query($sql);
$bi1 = 0;
$bi2 = 0;
$bi3 = 0;
$bi4 = 0;
$id_tb_alunos = "";
$nome_aluno = $_SESSION['nome'];
echo $nome_aluno;

while($row = $dados->fetch_assoc()){
    $GLOBALS['bi1'] = $row["nota_bimestre_01"];
    $GLOBALS['bi2'] = $row["nota_bimestre_02"];
    $GLOBALS['bi3'] = $row["nota_bimestre_03"];
    $GLOBALS['bi4'] = $row["nota_bimestre_04"];
    $GLOBALS['id_tb_alunos'] = $row['id']; 
}
   
$media = ($bi1 + $bi2 + $bi3 + $bi4)/4;
$aproveitamento = $media/10*100;
$maior_nivel = "";
$maior_nota = 1;
$quantidade_nota_empatada = 0;

//botão sair
if(!empty($_POST['sair'])){
    if(!isset($_SESSION)){
        session_start();
    }
    session_destroy();
    header("Location: login.php");
}

function maior_nota(){
    global $bi1; 
    if($GLOBALS['bi1']>=$GLOBALS['bi2'] && $GLOBALS['bi1']>=$GLOBALS['bi3'] && $GLOBALS['bi1']>=$GLOBALS['bi4']){
        $GLOBALS['maior_nota'] = $GLOBALS['bi1'];
        $GLOBALS['maior_nivel'] = situacao($GLOBALS['bi1']);
    }elseif($GLOBALS['bi2']>=$GLOBALS['bi1'] && $GLOBALS['bi2']>=$GLOBALS['bi3'] && $GLOBALS['bi2']>=$GLOBALS['bi4']){
        $GLOBALS['maior_nota'] = $GLOBALS['bi2'];
        $GLOBALS['maior_nivel'] = situacao($GLOBALS['bi2']);
    }elseif($GLOBALS['bi3']>=$GLOBALS['bi1'] && $GLOBALS['bi3']>=$GLOBALS['bi2'] && $GLOBALS['bi3']>=$GLOBALS['bi4']){
        $GLOBALS['maior_nota'] = $GLOBALS['bi3'];
        $GLOBALS['maior_nivel'] = situacao($GLOBALS['bi3']);
    }elseif($GLOBALS['bi4']>=$GLOBALS['bi1'] && $GLOBALS['bi4']>=$GLOBALS['bi2'] && $GLOBALS['bi4']>=$GLOBALS['bi3']){
        $GLOBALS['maior_nota'] = $GLOBALS['bi4'];
        $GLOBALS['maior_nivel'] = situacao($GLOBALS['bi4']);
    }
    if($GLOBALS['maior_nota'] == $GLOBALS['bi1']){
        $GLOBALS['quantidade_nota_empatada'] = 1;
    }
    if($GLOBALS['maior_nota'] == $GLOBALS['bi2']){
        $GLOBALS['quantidade_nota_empatada'] = $GLOBALS['quantidade_nota_empatada'] + 1;
    }
    if($GLOBALS['maior_nota'] == $GLOBALS['bi3']){
        $GLOBALS['quantidade_nota_empatada'] = $GLOBALS['quantidade_nota_empatada'] + 1;
    }
    if($GLOBALS['maior_nota'] == $GLOBALS['bi4']){
        $GLOBALS['quantidade_nota_empatada'] = $GLOBALS['quantidade_nota_empatada'] + 1;
    }
}

maior_nota();

function situacao($nota) {
    switch ($nota) {
        case $nota>0&&$nota<4:
            return "PÉSSIMO";
            break;
        case $nota>3&&$nota<6:
            return "RUIM";
            break;
        case $nota>5&&$nota<8:
            return "BOM";
            break;
        case $nota>7&&$nota<11:
            return "EXCELENTE";
            break;
}}

function situacaoF() {
    $nota = $GLOBALS['media'];
    switch ($nota) {
        case $nota>0&&$nota<4:
            $situacao = "PÉSSIMO";
            break;
        case $nota>3&&$nota<6:
            $situacao = "RUIM";
            break;
        case $nota>5&&$nota<8:
            $situacao = "BOM";
            break;
        case $nota>7&&$nota<11:
            $situacao = "EXCELENTE";
            break;
}return $situacao;}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo_boletim.css">
    <title>Boletin</title>
</head>
<body>
    <div class="conteiner">
        <form action="" method="post">
            <input type="submit" name="sair" value="Sair" id="btn_sair_boletin" class="botao">
        </form>
    <table>
    <thead>
        <th>1º Bimestre</th>
        <th>Situação 1º bimestre</th>
        <th>2 º Bimestre</th>
        <th>Situação 2º bimestre</th>
        <th>3º Bimestre</th>
        <th>Situação 3º bimestre</th>
        <th>4º Bimestre</th>
        <th>Situação 4º bimestre</th>
    </thead>
    <tbody>
        <tr>
            <td class="indicado"><?php echo "$bi1";?></td>
            <td class="resultado"><?php echo situacao($bi1);?></td>
            <td class="indicado"><?php echo "$bi2";?></td>
            <td class="resultado"><?php echo situacao($bi2);?></td>
            <td class="indicado"><?php echo "$bi3";?></td>
            <td class="resultado"><?php echo situacao($bi3);?></td>
            <td class="indicado"><?php echo "$bi4";?></td>
            <td class="resultado"><?php echo situacao($bi4);?></td>"
        </tr>
        <tr>

        </tr>
        <tr>
            <td class="titulo" colspan="2">notas exigidas por bimestre</td>
            <td class="indicado">6.0</td>
        </tr>
        <tr>
            <td class="titulo" colspan="2">média final do aluno</td>
            <td class="resultado"><?php echo "$media"; ?></td>
        </tr>
        <tr>
            <td class="titulo" colspan="2">situação do aluno</td>
            <td class="resultado"><?php echo situacaoF(); ?></td>
        </tr>
        <tr>
            <td class="titulo" colspan="2">procentagem de aproveitamento</td>
            <td class="resultado"><?php echo "$aproveitamento"; ?></td>
        </tr>
        <tr>

        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="8">mensagem final</th>
        </tr>
        <tr>
            <td colspan="8" class="resultado"><?php $situa = situacaoF(); if($media >= 6){echo "Parabens $nome_aluno! Voce foi aprovado nesse ano letivo em um nivel $situa, com uma procentagem de aproveitamento de $aproveitamento% e uma media final de $media";}
            //caso o aluno não tenha atingido a media
            else{echo "Estude mais $nome_aluno! Voce não foi aprovado nesse ano letivo.Seu nivel foi $situa, com uma procentagem de aproveitamento de $aproveitamento% e uma media final de $media";} ?></td>
        </tr>
        <tr>
            <td colspan="8" class="resultado">Destaques: no ano letivo que findou, o aluno obteve em <?php echo "$quantidade_nota_empatada"; if($quantidade_nota_empatada>1){
                echo " unidades";
            }else{
                echo " unidade";
            } ?> uma situação de nivel <?php echo "$maior_nivel";?></td>
        </tr>
    </tfoot>
    </table>
    </div>
</body>



