<?php
// Conexion a la base de datos usando PDO
$host = "localhost";
$dbname = "sistema_tickets";
$user = "root";
$pass = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    die("Error de conexion: " . $error->getMessage());
}
?>
