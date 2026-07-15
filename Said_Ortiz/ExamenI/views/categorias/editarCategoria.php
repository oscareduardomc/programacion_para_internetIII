<?php
    $id = $_GET['id'];
    $cat = CategoriaController::obtenerPorId($id);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        CategoriaController::actualizar($id, $_POST['nombre_categoria'], $_POST['descripcion']);
    }
?>
<h2>Editar Categoría</h2>
<div class="card p-4 shadow-sm mt-3" style="max-width: 650px;">
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nombre de la Categoría</label>
            <input type="text" name="nombre_categoria" class="form-control" value="<?php echo $cat['nombre_categoria']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3"><?php echo $cat['descripcion']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-warning">Actualizar</button>
        <a href="index.php?action=categorias" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
