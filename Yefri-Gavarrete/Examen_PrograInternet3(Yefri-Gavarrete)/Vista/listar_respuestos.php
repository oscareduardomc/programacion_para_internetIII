<?php

$repuestos = TallerController::listarRespuestos();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Lista de Repuestos</h2>
     <a href="index.php?action=categorias" class="btn btn-secondary">Categorias</a>
    <a href="index.php?action=crear" class="btn btn-primary">Nuevo Repuesto</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success">
        operacion realizada correctamente
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        No se pudo realizar esta accion
    </div>
<?php endif; ?>

<table class="table table-hover table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Stock</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($repuestos as $repuesto): ?>
            <tr class="<?php echo $repuesto['stock'] < 5 ? 'table-warning' : ''; ?>">
                <td><?php echo htmlspecialchars($repuesto['codigo_pieza']); ?></td>
                <td><?php echo htmlspecialchars($repuesto['nombre']); ?></td>
                <td><?php echo htmlspecialchars($repuesto['nombre_categoria']); ?></td>
                <td><?php echo $repuesto['stock']; ?></td>
                <td><?php echo number_format($repuesto['precio'], 2); ?></td>
                <td>
                    <a href="index.php?action=editar&id=<?php echo $repuesto['id']; ?>" class="btn btn-warning btn-sm">
                        Editar
                    </a>

                    <a href="index.php?action=desactivar&id=<?php echo $repuesto['id']; ?>" 
                       class="btn btn-secondary btn-sm"
                       onclick="return confirm('¿Desea desactivar este repuesto?')">
                        Desactivar
                    </a>

                    <a href="index.php?action=eliminar&id=<?php echo $repuesto['id']; ?>" 
                       class="btn btn-danger"
                       onclick="return confirm('Solo se eliminará si el stock esta en 0. ¿Continuar?')">
                        Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>