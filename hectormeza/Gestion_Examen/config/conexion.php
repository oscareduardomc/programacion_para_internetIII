<?php

    $host = "localhost";
    $db   = "gestion";
    $user = "root";
    $pass = "";

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $error) {
        die("Error de conexion: " . $error->getMessage());
    }
?>
