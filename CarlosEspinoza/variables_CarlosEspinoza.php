<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Variables de Inventario - Carlos Espinoza</title>
</head>
<body>
    <h1>DETALLES DEL PRODUCTO</h1>
    <ol>
        <?php
        $nombreProducto = "Camiseta Sportiva de Algodón para Hombre";
        $precio = 578.99;
        $enInventario = 50;

        echo "<li><strong>Nombre del producto:</strong> $nombreProducto</li>";
        echo "<li><strong>Precio:</strong> Lps. $precio</li>";
        echo "<li><strong>En inventario:</strong> $enInventario unidades</li>";
        ?>
    </ol>

</body>
</html>

