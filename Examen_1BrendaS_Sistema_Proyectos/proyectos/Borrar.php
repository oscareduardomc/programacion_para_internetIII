<?php
require_once "../conexion/conexion.php";

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$id_cliente = $_POST['id_cliente'];
$presupuesto = $_POST['presupuesto'];
$fecha = $_POST['fecha_entrega'];

$sql = "UPDATE proyectos SET
        titulo = '$titulo',
        descripcion = '$descripcion',
        id_cliente = '$id_cliente',
        presupuesto = '$presupuesto',
        fecha_entrega = '$fecha'
        WHERE id = '$id'";

$conexion->exec($sql);

header("Location: index.php");
exit();
?>