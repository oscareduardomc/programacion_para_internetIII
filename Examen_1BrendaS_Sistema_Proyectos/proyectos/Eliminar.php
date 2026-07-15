<?php
require_once "../conexion/conexion.php";

$id = $_GET['id'];

$sql = "UPDATE proyectos SET activo = 0 WHERE id = :id";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

header("Location: index.php");
exit();
?>