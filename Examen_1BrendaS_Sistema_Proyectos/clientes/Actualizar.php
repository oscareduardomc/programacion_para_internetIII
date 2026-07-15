<?php
require_once "../conexion/conexion.php";

$id = $_POST['id'];
$nombre = $_POST['nombre_empresa'];
$correo = $_POST['correo_contacto'];
$telefono = $_POST['telefono'];

$sql = "UPDATE clientes SET
        nombre_empresa = '$nombre',
        correo_contacto = '$correo',
        telefono = '$telefono'
        WHERE id = '$id'";

$conexion->exec($sql);

header("Location: index.php");
exit();
?>