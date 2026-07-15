<?php
require_once "../conexion/conexion.php";

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$id_cliente = $_POST['id_cliente'];
$presupuesto = $_POST['presupuesto'];
$fecha = $_POST['fecha_entrega'];

$sql = "INSERT INTO proyectos 
(titulo, descripcion, id_cliente, presupuesto, fecha_entrega)
VALUES (:titulo, :descripcion, :id_cliente, :presupuesto, :fecha)";

$stmt = $conexion->prepare($sql);

$stmt->bindParam(":titulo", $titulo);
$stmt->bindParam(":descripcion", $descripcion);
$stmt->bindParam(":id_cliente", $id_cliente);
$stmt->bindParam(":presupuesto", $presupuesto);
$stmt->bindParam(":fecha", $fecha);

$stmt->execute();

header("Location: index.php");
exit();
?>