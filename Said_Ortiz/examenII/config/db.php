<?php

$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "soporte_tickets";

$conn = new mysqli(
    $host,
    $usuario,
    $password,
    $base_datos
);

if ($conn->connect_error) {
    die("Error de conexion a la base de datos: " . $conn->connect_error);
}

$conn->set_charset('utf8mb4');

?>
