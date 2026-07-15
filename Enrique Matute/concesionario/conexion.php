<?php
// 1. Datos de conexión
$host = "localhost";
$basedatos = "concesionario";
$usuario = "root";
$clave = "";

// 2. Crear el objeto PDO con manejo de excepciones
try {
    $conexion = new PDO("mysql:host=$host;dbname=$basedatos;charset=utf8", $usuario, $clave);
    // 3. Configurar para que los errores lancen excepciones
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    echo "Error de conexión: " . $error->getMessage();
}
?>
