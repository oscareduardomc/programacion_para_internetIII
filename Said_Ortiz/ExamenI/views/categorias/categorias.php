<?php
    $categorias = CategoriaController::listar();
?>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?php
            if($_GET['msg'] == 'guardado') echo "¡Categoría guardada con éxito!";
            if($_GET['msg'] == 'actualizado') echo "¡Categoría actualizada correctamente!";
            if($_GET['msg'] == 'desactivado') echo "Categoría dada de baja de manera lógica.";
            if($_GET['msg'] == 'eliminado') echo "Categoría borrada de forma física.";
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Lista de Categorías</h2>
    <a href="index.php?action=crearCategoria" class="btn btn-primary"><i class="bi bi-folder-plus me-1"></i>Nueva Categoría</a>
</div>

<table class="table table-hover border">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre de Categoría</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($categorias as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= $c['nombre_categoria'] ?></td>
            <td><?= $c['descripcion'] ?></td>
            <td>
                <a href="index.php?action=editarCategoria&id=<?= $c['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="index.php?action=desactivarCategoria&id=<?= $c['id'] ?>" class="btn btn-secondary btn-sm" onclick="return confirm('¿Desactivar lógicamente esta categoría?')">Desactivar</a>
                <a href="index.php?action=eliminarCategoria&id=<?= $c['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar físicamente de la BD?')">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
