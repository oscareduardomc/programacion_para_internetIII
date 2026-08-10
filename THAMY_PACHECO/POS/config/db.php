<?php

$host = "localhost";
$usuario = "root";
$pasword = "";
$base_datos = "punto_venta";

$conn = new mysqli(
    $host,
    $usuario,
    $pasword,
    $base_datos
);


if ($conn->connect_error){
    die ("error de conexion a la base de datos: ".$conn->connect_error);
}

$conn->set_charset('utf8mb4');


?>