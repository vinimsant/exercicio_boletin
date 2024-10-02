<?php
    $host = "localhost";
    $banco = "boletin";
    $senha = "";
    $usuario = "root";
    $con = mysqli_connect($host, $usuario, $senha, $banco);
    if($con->connect_error){
        die("Conexão falhou".$con->connect_error);
    }else{
        echo "Conectado <br/>";
    }

?>