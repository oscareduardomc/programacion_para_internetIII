<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio de variables</title>
</head>
<body>

    <?php
        $nombre_producto = "Samsung Galaxy S23 Ultra";
        $precio = 21500;
        $cantidad_inventario = 6;
        $disponibilidad = true;
    ?>

    <h1><strong>Detalles del Producto</strong></h1>
        <ol>
            <li><strong>Nombre del Producto:</strong> <?php echo $nombre_producto; ?></li>
            <li><strong>Precio:</strong> $<?php echo $precio; ?></li>
            <li><strong>Cantidad en Inventario:</strong> <?php echo $cantidad_inventario; ?> unidades</li>
            <li><strong>Disponibilidad:</strong> <?php echo $disponibilidad ? "Si" : "No"; ?></li>
        </ol>

</body>
</html>
