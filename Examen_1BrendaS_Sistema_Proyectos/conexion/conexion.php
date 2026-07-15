<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$dbname = "sistema_proyectos";
$usuario = "root";
$password = "";

try {

    $conexion = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $usuario,
        $password
    );

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "CONEXIÓN OK"; 

} catch (PDOException $e) {

    die("Error de conexión: " . $e->getMessage());
}