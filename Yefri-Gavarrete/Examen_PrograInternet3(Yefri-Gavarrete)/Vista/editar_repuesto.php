<?php
$id = $_GET['id'];

$repuesto = TallerController::obtenerPorId($id);
$categorias = TallerController::listarCategorias();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    TallerController::editarRepuesto(
        $id,
        $_POST['codigo_pieza'],
        $_POST['nombre'],
        $_POST['id_categoria'],
        $_POST['stock'],
        $_POST['precio']
    );
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Editar Repuesto</h2>
    <a href="index.php" class="btn btn-secondary">Volver</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="index.php?action=editar&id=<?php echo $id; ?>" method="POST">

            <input type="hidden" name="id" value="<?php echo $repuesto['id']; ?>">

            <div class="mb-3">
                <label class="form-label">Código de Pieza</label>
                <input type="text" name="codigo_pieza" class="form-control"
                       value="<?php echo htmlspecialchars($repuesto['codigo_pieza']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control"
                       value="<?php echo htmlspecialchars($repuesto['nombre']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Categoría</label>
                <select name="id_categoria" class="form-select" required>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria['id']; ?>"
                            <?php echo $categoria['id'] == $repuesto['id_categoria'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($categoria['nombre_categoria']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Stock</label>
                <input type="number" name="stock" class="form-control"
                       value="<?php echo $repuesto['stock']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input type="number"name="precio" class="form-control"
                       value="<?php echo $repuesto['precio']; ?>" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
            </div>

        </form>
    </div>
</div>