<?php
require_once "../conexion/conexion.php";

$id = $_GET['id'];


$sql = "SELECT * FROM proyectos WHERE id = :id";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();
$proyecto = $stmt->fetch(PDO::FETCH_ASSOC);

$sql2 = "SELECT * FROM clientes WHERE activo = 1";
$stmt2 = $conexion->prepare($sql2);
$stmt2->execute();
$clientes = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

<h2>Editar Proyecto</h2>

<form action="actualizar.php" method="POST">

    <input type="hidden" name="id" value="<?= $proyecto['id'] ?>">


    <input type="text" name="titulo"
           value="<?= $proyecto['titulo'] ?>"
           class="form-control mb-2"
           placeholder="Título">

    
    <input type="text" name="descripcion"
           value="<?= $proyecto['descripcion'] ?>"
           class="form-control mb-2"
           placeholder="Descripción">


    <select name="id_cliente" class="form-control mb-2">
        <?php foreach($clientes as $c){ ?>
            <option value="<?= $c['id'] ?>"
                <?= $c['id'] == $proyecto['id_cliente'] ? 'selected' : '' ?>>
                <?= $c['nombre_empresa'] ?>
            </option>
        <?php } ?>
    </select>

    
    <input type="number" name="presupuesto"
           value="<?= $proyecto['presupuesto'] ?>"
           class="form-control mb-2"
           placeholder="Presupuesto">


    <input type="date" name="fecha_entrega"
           value="<?= $proyecto['fecha_entrega'] ?>"
           class="form-control mb-2">

    <button class="btn btn-primary">Actualizar</button>

    <a href="index.php" class="btn btn-secondary">Volver</a>

</form>

</div>

</body>
</html>