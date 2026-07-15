<?php
    $host = "localhost";
    $username = "root";
    $database = "taller";
    $password = "";

    try{
        $conexion = new PDO("mysql:host=$host;dbname=$database", $username, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        die($e->getMessage());
    }