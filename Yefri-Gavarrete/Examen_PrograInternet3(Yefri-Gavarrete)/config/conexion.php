

<?php
    
    $host = "localhost";
    $dbuser = "taller_db";
    $user = "root";
    $pass = "Yefrigd12354.";

    try{
        $conexion = new PDO("mysql:host=$host; dbname=$dbuser; parset=utf8", $user, $pass);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    }catch (PDOException $error){
        die("Error de conexion" . $error->getMessage());



    }




?>