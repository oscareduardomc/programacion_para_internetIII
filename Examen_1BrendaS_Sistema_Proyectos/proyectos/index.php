<?php
require_once "../conexion/conexion.php";

$sql = "SELECT 
            p.id,
            p.titulo,
            p.descripcion,
            p.presupuesto,
            p.fecha_entrega,
            c.nombre_empresa
        FROM proyectos p
        INNER JOIN clientes c ON p.id_cliente = c.id
        WHERE p.activo = 1";

$stmt = $conexion->prepare($sql);
$stmt->execute();
$proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Proyectos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">

<h2 class="text-center mb-4">Gestión de Proyectos</h2>

<a href="agregar.php" class="btn btn-success mb-3">+ Nuevo Proyecto</a>

<table class="table table-bordered table-hover bg-white">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Cliente</th>
            <th>Presupuesto</th>
            <th>Entrega</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach($proyectos as $p){ ?>
        <tr>
            <td><?= $p['id'] ?></td>
            <td><?= $p['titulo'] ?></td>
            <td><?= $p['nombre_empresa'] ?></td>
            <td><?= $p['presupuesto'] ?></td>
            <td><?= $p['fecha_entrega'] ?></td>
            <td>
                <a href="editar.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="eliminar.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
                <a href="borrar.php?id=<?= $p['id'] ?>" class="btn btn-dark btn-sm"
                   onclick="return confirm('¿Eliminar definitivamente?')">Borrar</a>
            </td>
        </tr>
    <?php } ?>
    </tbody>

</table>

</div>

</body>
</html>