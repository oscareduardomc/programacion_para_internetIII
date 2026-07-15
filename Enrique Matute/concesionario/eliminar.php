<?php
// 1. Obtener el id del vehículo por la URL
$id = $_GET['id'];

// 2. HARD DELETE: elimina el registro por completo de la base de datos
$sql = "DELETE FROM vehiculos WHERE id = :id";
$consulta = $conexion->prepare($sql);
$consulta->bindParam(":id", $id);
$consulta->execute();

// 3. Redirigir con alerta
header("Location: index.php?action=listar&msg=eliminado");
exit;
?>
