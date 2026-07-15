<?php
    $producto = "Laptop ASUS ROG Strix";
    $precio = 1250.99;
    $cantidad = 13;
    $disponible = true;
?>

<h3>Detalle del Producto:</h3>
<ol>
    <li>Producto: <?php echo $producto; ?></li>
    <li>Precio: $<?php echo $precio; ?></li>
    <li>Disponibilidad: <?php echo $cantidad; ?> unidades en la bodega.</li>
</ol>
