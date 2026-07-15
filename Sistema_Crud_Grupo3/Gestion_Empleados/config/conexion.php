<?php
    
    $host = "localhost";
    $db = "sistema_empleados";
    $user = "root";

    //Aqui uso mi password mysql porque ya tenia configurado anteriormente un usuario root, no la subi al repo.
    $pass = "";

    try{
        $conexion = new PDO("mysql:host=$host; dbname=$db; parset=utf8", $user, $pass);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    }catch (PDOException $error){
        die("Error de conexion" . $error->getMessage());



    }




?>