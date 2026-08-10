<?php

require "includes/session.php";
require "config/db.php";

if (!isset($_GET['id'])) {

    header("Location: productos.php");
    exit;
}

$id_producto = intval($_GET['id']);

$query = "SELECT * FROM productos WHERE id_producto = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$res_prod = $stmt->get_result();

if ($res_prod->num_rows == 0) {

    header("Location: productos.php");
    exit;
}

$prod = $res_prod->fetch_assoc();

$sql_cat = "SELECT id_categoria, categoria FROM categorias WHERE estado = 1 ORDER BY categoria ASC";
$res_cat = $conn->query($sql_cat);

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>
<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-pen-to-square"></i>
            Editar Producto
        </h2>
        <a href="productos.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Regresar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="controllers/actualizarProducto.php" method="POST">
                <input type="hidden" name="id_producto" value="<?php echo $prod['id_producto']; ?>">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Código de Barras / SKU</label>
                        <input type="text" name="codigo" class="form-control" required value="<?php echo $prod['codigo']; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre del Producto</label>
                        <input type="text" name="nombre" class="form-control" required value="<?php echo $prod['nombre']; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Categoría</label>
                        <select name="id_categoria" class="form-control select2" required>
                            <option value="">Seleccione una opción</option>
                            <?php while ($cat = $res_cat->fetch_assoc()) { ?>
                                <option value="<?php echo $cat['id_categoria']; ?>"
                                    <?php if ($cat['id_categoria'] == $prod['id_categoria']) echo "selected"; ?>>
                                    <?php echo $cat['categoria']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Stock Actual</label>
                        <input type="number" name="stock" class="form-control" value="<?php echo $prod['stock']; ?>" min="0" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Stock Mínimo</label>
                        <input type="number" name="stock_minimo" class="form-control" value="<?php echo $prod['stock_minimo']; ?>" min="1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Precio Costo (L)</label>
                        <input type="number" step="0.01" name="precio_costo" class="form-control" value="<?php echo $prod['precio_costo']; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Precio Venta (L)</label>
                        <input type="number" step="0.01" name="precio_venta" class="form-control" value="<?php echo $prod['precio_venta']; ?>" required>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Actualizar Producto
                </button>
            </form>
        </div>
    </div>
</div>

<?php
include "includes/footer.php";
?>
