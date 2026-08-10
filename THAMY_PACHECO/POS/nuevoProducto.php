<?php

require "includes/session.php";
require "config/db.php";

$sql_cat = "SELECT id_categoria, categoria FROM categorias WHERE estado = 1 ORDER BY categoria ASC";
$res_cat = $conn->query($sql_cat);

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>
<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-box-open"></i>
            Nuevo Producto
        </h2>
        <a href="productos.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Regresar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="controllers/guardarProducto.php" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Código de Barras / SKU</label>
                        <input type="text" class="form-control" name="codigo" placeholder="Ej. 750123456789" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ej. Coca Cola 355ml" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Categoría</label>
                        <select name="id_categoria" class="form-control select2" required>
                            <option value="">Seleccione una opción</option>
                            <?php while ($cat = $res_cat->fetch_assoc()) { ?>
                                <option value="<?php echo $cat['id_categoria']; ?>">
                                    <?php echo $cat['categoria']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="" class="form-label">Stock Inicial</label>
                        <input type="number" class="form-control" name="stock" value="0" min="0" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="" class="form-label">Stock Mínimo</label>
                        <input type="number" class="form-control" name="stock_minimo" value="5" min="1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Precio Costo (L)</label>
                        <input type="number" step="0.01" class="form-control" name="precio_costo" placeholder="0.00" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Precio Venta (L)</label>
                        <input type="number" step="0.01" class="form-control" name="precio_venta" placeholder="0.00" required>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i>
                    Guardar Producto
                </button>
            </form>
        </div>
    </div>
</div>

<?php
include "includes/footer.php";
?>
