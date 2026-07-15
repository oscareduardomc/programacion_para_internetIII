<?php
require_once __DIR__ . '/../controladores/categoriaController.php';
$catCtrl = new categoriaController($conexion);
$categorias = $catCtrl->listar();
?>

<h2>Nuevo Repuesto</h2>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form method="POST" action="index.php?action=guardar">
            <div class="mb-3">
                <label>Codigo de pieza</label>
                <input type="text" name="codigo_pieza" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Nombre del repuesto</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Categoria</label>
                <select name="id_categoria" class="form-select" required>
                    <option value="">Seleccione</option>
                    <?php if ($categorias && $categorias->rowCount() > 0): ?>
                        <?php while ($cat = $categorias->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $cat['id']; ?>">
                                <?php echo htmlspecialchars($cat['nombre_categoria']); ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Stock</label>
                <input type="number" name="stock" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Precio</label>
                <input type="number" step="0.01" name="precio" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
