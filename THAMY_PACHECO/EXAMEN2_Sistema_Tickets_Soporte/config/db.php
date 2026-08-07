<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "sistema_tickets_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
