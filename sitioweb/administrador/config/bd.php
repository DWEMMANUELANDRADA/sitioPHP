<?php
$host="127.0.0.1";
$bd="sitio";
$usuario="root";
$contrasenia="";
try{
    $conexion =new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasenia);
    
}catch(Exception $ex){
    echo $ex->getMessage();
}
?>