<?php

require "includes/session.php";
require "config/db.php";

$query = "
    SELECT p.*, c.categoria
    FROM productos p
    LEFT JOIN categorias c
    ON p.id_categoria = c.id_categoria
    ORDER BY p.id_producto DESC
";
$resultado = $conn->query($query);

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-box"></i>
            Productos
        </h2>
        <a class="btn btn-primary" href="nuevoProducto.php">
            <i class="fa-solid fa-plus"></i>
            Nuevo Producto
        </a>
    </div>

    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?php echo $_SESSION['tipo']; ?>">
            <?php echo $_SESSION['mensaje']; ?>
        </div>
    <?php
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
    } ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio Costo</th>
                            <th>Precio Venta</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($prod = $resultado->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $prod['id_producto']; ?></td>
                                <td><?php echo $prod['codigo']; ?></td>
                                <td><?php echo $prod['nombre']; ?></td>
                                <td><?php echo $prod['categoria'] ?? 'Sin categoría'; ?></td>
                                <td>L <?php echo number_format($prod['precio_costo'], 2); ?></td>
                                <td>L <?php echo number_format($prod['precio_venta'], 2); ?></td>
                                <td>
                                    <?php echo $prod['stock']; ?>
                                    <?php if ($prod['stock'] <= $prod['stock_minimo']) { ?>
                                        <span class="badge bg-warning text-dark">Stock bajo</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($prod['estado'] == 1) { ?>
                                        <span class="badge bg-success">Activo</span>
                                    <?php } else { ?>
                                        <span class="badge bg-danger">Inactivo</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="editarProducto.php?id=<?php echo $prod['id_producto']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <?php if ($prod['estado'] == 1) { ?>
                                        <a href="controllers/eliminarProducto.php?id=<?php echo $prod['id_producto']; ?>"
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('¿Desea desactivar este producto?')">
                                            <i class="fa-solid fa-user-slash"></i>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include "includes/footer.php";
?>
