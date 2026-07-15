<?php
$id = $_GET['id'];
$repuesto = RepuestoControllers::obtenerPorId($id);
  $categorias = RepuestoControllers::obtenerCategorias();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    RepuestoControllers::actualizar($id, $_POST['codigo'], $_POST['nombre'], $_POST['id_categoria'], $_POST['stock'], $_POST['precio']);
}
?>

<h2>Editar Repuesto</h2>
<div class="card p-4 shadow-sm mt-3" style="max-width: 600px;">
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Código de Pieza</label>
            <input type="text" name="codigo" class="form-control" value="<?php echo $repuesto['codigo_pieza']; ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Nombre del Repuesto</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $repuesto['nombre']; ?>" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="id_categoria" class="form-control" required>
                <?php foreach($categorias as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $repuesto['id_categoria']) ? 'selected' : ''; ?>>
                        <?php echo ($cat['nombre_categoria']); ?>
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