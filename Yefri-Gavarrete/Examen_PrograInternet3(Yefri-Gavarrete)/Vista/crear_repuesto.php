<?php
$categorias = TallerController::listarCategorias();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Registrar Repuesto</h2>
    <a href="index.php" class="btn btn-secondary">Volver</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="index.php?action=guardar" method="POST">

            <div class="mb-3">
                <label class="form-label">Código de Pieza</label>
                <input type="text" name="codigo_pieza" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Categoría</label>
                <select name="id_categoria" class="form-select" required>
                    <option value="">Seleccione una categoría</option>

                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria['id']; ?>">
                            <?php echo htmlspecialchars($categoria['nombre_categoria']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input type="number" name="precio" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
            </div>

        </form>
    </div>
</div>