<?php
// 1. Obtener el id del vehículo por la URL
$id = $_GET['id'];

// 2. SOFT DELETE: no se borra, solo se cambia la bandera de estado a 0
//    El auto "se vendió": sigue en la base, pero ya no aparece en la lista de activos.
$sql = "UPDATE vehiculos SET estado_activo = 0 WHERE id = :id";
$consulta = $conexion->prepare($sql);
$consulta->bindParam(":id", $id);
$consulta->execute();

// 3. Redirigir con alerta
header("Location: index.php?action=listar&msg=desactivado");
exit;
?>