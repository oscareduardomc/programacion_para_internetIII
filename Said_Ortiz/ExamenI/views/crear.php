<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        RepuestoController::guardar($_POST['codigo_pieza'], $_POST['nombre'], $_POST['id_categoria'], $_POST['stock'], $_POST['precio']);
    }
    $categorias = CategoriaController::listar();
?>
<h2>Agregar Nuevo Repuesto</h2>
<div class="card p-4 shadow-sm mt-3" style="max-width: 650px;">
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Código de la Pieza</label>
            <input type="text" name="codigo_pieza" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nombre del Repuesto</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="id_categoria" class="form-select" required>
                <option value="">Seleccione una categoría</option>

                <?php foreach ($categorias as $c): ?>
                    <option value="<?php echo $c['id']; ?>"><?php echo $c['nombre_categoria']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar Repuesto</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
