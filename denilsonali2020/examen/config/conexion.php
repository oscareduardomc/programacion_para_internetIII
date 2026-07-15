<?php

// 1. Definir parametros de conexion
$host = "localhost";
$db_name = "examen";
$db_username = "root";
$db_password = "Alfa2020+";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_username, $db_password);

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    die("Error critico en conexion: " . $error->getMessage());
}
