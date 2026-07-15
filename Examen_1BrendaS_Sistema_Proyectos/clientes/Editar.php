<?php
require_once "../conexion/conexion.php";

$id = $_GET['id'];

$sql = "SELECT * FROM clientes WHERE id = '$id'";
$resultado = $conexion->query($sql);

$cliente = $resultado->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<h2>Editar Cliente</h2>

<form action="actualizar.php" method="POST">

    <input type="hidden" name="id" value="<?= $cliente['id'] ?>">

    <input type="text" name="nombre_empresa"
           value="<?= $cliente['nombre_empresa'] ?>"
           class="form-control mb-2"
           placeholder="Empresa">

    <input type="email" name="correo_contacto"
           value="<?= $cliente['correo_contacto'] ?>"
           class="form-control mb-2"
           placeholder="Correo">

    <input type="text" name="telefono"
           value="<?= $cliente['telefono'] ?>"
           class="form-control mb-2"
           placeholder="Teléfono">

    <button class="btn btn-primary">Actualizar</button>

    <a href="index.php" class="btn btn-secondary">Volver</a>

</form>

</div>

</body>
</html>