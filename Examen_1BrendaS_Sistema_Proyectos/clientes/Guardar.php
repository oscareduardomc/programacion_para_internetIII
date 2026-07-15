<?php
require_once "../conexion/conexion.php";

$nombre = $_POST['nombre_empresa'];
$correo = $_POST['correo_contacto'];
$telefono = $_POST['telefono'];

$sql = "INSERT INTO clientes(nombre_empresa, correo_contacto, telefono)
        VALUES ('$nombre', '$correo', '$telefono')";

$conexion->exec($sql);

header("Location: index.php");
exit();
?>