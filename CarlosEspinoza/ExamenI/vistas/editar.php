<?php
require_once __DIR__ . '/../controladores/categoriaController.php';

$id = $_GET['id'];
$repuesto = respuestosController::obtenerPorId($id);

if (!$repuesto || isset($repuesto['error'])) {
    header("Location: index.php?error=Repuesto no encontrado");
    exit();
}

$catCtrl = new categoriaController($conexion);
$categorias = $catCtrl->listar();
?>

<h2>Editar Repuesto</h2>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form method="POST" action="index.php?action=actualizar">
            <input type="hidden" name="id" value="<?php echo $repuesto['id']; ?>">
            <div class="mb-3">
                <label>Codigo de pieza</label>
                <input type="text" name="codigo_pieza" class="form-control"
                    value="<?php echo htmlspecialchars($repuesto['codigo_pieza']); ?>" required>
            </div>
            <div class="mb-3">
                <label>Nombre del repuesto</label>
                <input type="text" name="nombre" class="form-control"
                    value="<?php echo htmlspecialchars($repuesto['nombre']); ?>" required>
            </div>
            <div class="mb-3">
                <label>Categoria</label>
                <select name="id_categoria" class="form-select" required>
                    <option value="">Seleccione</option>
                    <?php if ($categorias && $categorias->rowCount() > 0): ?>
                        <?php while ($cat = $categorias->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $cat['id']; ?>"
                                <?php echo ((int)$cat['id'] === (int)$repuesto['id_categoria']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['nombre_categoria']); ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Stock</label>
                <input type="number" name="stock" class="form-control"
                    value="<?php echo $repuesto['stock']; ?>" required>
            </div>
            <div class="mb-3">
                <label>Precio</label>
                <input type="number" step="0.01" name="precio" class="form-control"
                    value="<?php echo $repuesto['precio']; ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Actualizar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
