<?php
    $repuestos = RepuestoController::listar();
?>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?php
            if($_GET['msg'] == 'guardado') echo "¡Repuesto guardado con éxito!";
            if($_GET['msg'] == 'actualizado') echo "¡Repuesto actualizado correctamente!";
            if($_GET['msg'] == 'desactivado') echo "Pieza desactivada por obsolescencia (Borrado lógico).";
            if($_GET['msg'] == 'eliminado') echo "Repuesto eliminado físicamente del sistema.";
            if($_GET['msg'] == 'stock') echo "<strong>Error:</strong> No se puede eliminar de forma física porque aún tiene unidades en stock.";
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Lista de Repuestos</h2>
    <a href="index.php?action=crear" class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Nuevo Repuesto</a>
</div>

<table class="table table-hover border">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Código</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Stock</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($repuestos as $r): ?>
        <tr class="<?= ($r['stock'] < 5) ? 'table-warning' : '' ?>">
            <td><?= $r['id'] ?></td>
            <td><?= $r['codigo_pieza'] ?></td>
            <td><?= $r['nombre'] ?></td>
            <td><?= $r['nombre_categoria'] ?></td>
            <td><?= $r['stock'] ?></td>
            <td>L. <?= number_format($r['precio'], 2) ?></td>
            <td>
                <a href="index.php?action=editar&id=<?= $r['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="index.php?action=desactivar&id=<?= $r['id'] ?>" class="btn btn-secondary btn-sm" onclick="return confirm('¿Inactivar pieza por obsolescencia?')">Desactivar</a>
                <a href="index.php?action=eliminar&id=<?= $r['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea borrar físicamente este registro?')">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
