<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../conexion/conexion.php";

$sql = "SELECT * FROM clientes WHERE activo = 1";
$resultado = $conexion->query($sql);

$clientes = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">

    <h2>Clientes</h2>

    <a href="agregar.php" class="btn btn-primary mb-2">Nuevo</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Empresa</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach($clientes as $c){ ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= $c['nombre_empresa'] ?></td>
                <td><?= $c['correo_contacto'] ?></td>
                <td><?= $c['telefono'] ?></td>
                <td>
                    <a href="editar.php?id=<?= $c['id'] ?>" class="btn btn-warning btn-sm">Editar</a>

                    <a href="eliminar.php?id=<?= $c['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>

                    <a href="borrar.php?id=<?= $c['id'] ?>" class="btn btn-dark btn-sm"
                       onclick="return confirm('¿Borrar definitivamente?')">
                       Borrar
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>

    </table>

</div>

</body>
</html>