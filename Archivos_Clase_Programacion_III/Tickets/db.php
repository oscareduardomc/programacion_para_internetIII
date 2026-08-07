<?php

$host = "127.0.0.1";
$usuario = "root";
$password = "";
$base_datos = "sistema_tickets";
$puerto = 3307;

//Ing si ve mas cosas aqui es que batallo mucho con el puerto 3306 de XAAMP por que uso otros programas para otras clases y me toca agregarle algo mas!!

$conn = new mysqli(
    $host,
    $usuario,
    $password,
    $base_datos,
    $puerto
);

if ($conn->connect_error){
    die("Error de conexion a la base de datos: " . $conn->connect_error);
}

$conn->set_charset('utf8mb4');

?>