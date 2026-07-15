<?php
$host = "localhost";
$db_name = "examen_agencia";
$username = "root";
$password = "";

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    echo "Error en la conexion: " . $error->getMessage();
}
?>
