<?php
    $user = "root";
    $password = "";
    $banco = "boletin";
    $host = "mysql:host=localhost:8090;dbname=boletin";

    $con = new mysqli($host, $user, $password, $banco);

    if(!$con){
        die("Falha na conexão: ".mysqli_connect_error());
    }
    try{
        $pdo = new PDO($host, $user, $password);
    }catch(Exception $e){
        echo "Erro $e";
    }
   

?>