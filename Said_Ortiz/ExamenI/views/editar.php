<?php
    $id = $_GET['id'];
    $repuesto = RepuestoController::obtenerPorId($id);
    $categorias = CategoriaController::listar();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        RepuestoController::actualizar($id, $_POST['codigo_pieza'], $_POST['nombre'], $_POST['id_categoria'], $_POST['stock'], $_POST['precio']
        );
    }
?>
<h2>Editar Repuesto</h2>
<div class="card p-4 shadow-sm mt-3" style="max-width: 650px;">
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Código de la Pieza</label>
            <input type="text" name="codigo_pieza" class="form-control" value="<?php echo $repuesto['codigo_pieza']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nombre del Repuesto</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $repuesto['nombre']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="id_categoria" class="form-select" required>
                <?php foreach ($categorias as $c): ?>
                    <option value="<?php echo $c['id']; ?>" <?php if ($c['id'] == $repuesto['id_categoria']) echo "selected"; ?>>
                        <?php echo $c['nombre_categoria']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="<?php echo $repuesto['stock']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo $repuesto['precio']; ?>" required>
        </div>
        <button type="submit" class="btn btn-warning">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
