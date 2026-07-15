<?php
    $host = "localhost";    
    $db_name = "taller_repuestos";
    $username = "root";
    $password = "";

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $error) {
      die("Error critico de conexion: " . $error->getMessage());
    }
?>