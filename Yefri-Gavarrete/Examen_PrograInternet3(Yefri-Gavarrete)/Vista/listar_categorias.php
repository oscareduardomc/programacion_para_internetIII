<?php
$categorias = TallerController::listarCategorias();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Lista de Categorías</h2>

    <div>
        <a href="index.php" class="btn btn-secondary">Volver a Repuestos</a>
        <a href="index.php?action=crear_categoria" class="btn btn-primary">Nueva Categoría</a>
    </div>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success">
        Operacion realizada correctamente
    </div>
<?php endif; ?>

<table class="table table-hover table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre de Categoria</th>
            <th>Descripción</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($categorias as $categoria): ?>
            <tr>
                <td><?php echo $categoria['id']; ?></td>
                <td><?php echo htmlspecialchars($categoria['nombre_categoria']); ?></td>
                <td><?php echo htmlspecialchars($categoria['descripcion']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>