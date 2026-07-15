<?php
require_once "../conexion/conexion.php";

$sql = "SELECT * FROM clientes WHERE activo = 1";
$resultado = $conexion->query($sql);

$clientes = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<h2>Nuevo Proyecto</h2>

<form action="guardar.php" method="POST">

    <input type="text" name="titulo"
           class="form-control mb-2"
           placeholder="Título">

    <input type="text" name="descripcion"
           class="form-control mb-2"
           placeholder="Descripción">

    <select name="id_cliente" class="form-control mb-2">
        <option value="">Seleccionar cliente</option>

        <?php foreach($clientes as $c){ ?>
            <option value="<?= $c['id'] ?>">
                <?= $c['nombre_empresa'] ?>
            </option>
        <?php } ?>

    </select>

    <input type="number" name="presupuesto"
           class="form-control mb-2"
           placeholder="Presupuesto">

    <input type="date" name="fecha_entrega"
           class="form-control mb-2">

    <button class="btn btn-success">Guardar</button>

    <a href="index.php" class="btn btn-secondary">Volver</a>

</form>

</div>

</body>
</html>