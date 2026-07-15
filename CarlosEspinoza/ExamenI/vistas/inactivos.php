<?php
$repuestosInactivos = respuestosController::listarInactivos();
?>

<h2>Repuestos Inactivos</h2>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success">
        <?php echo htmlspecialchars($_GET['mensaje']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
<?php endif; ?>

<table class="table table-bordered">
    <thead class="table-secondary">
        <tr>
            <th>ID</th>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Categoria</th>
            <th>Stock</th>
            <th>Precio</th>
            <th>Accion</th>
        </tr>
    </thead>
    <tbody>
        <?php if (is_array($repuestosInactivos) && count($repuestosInactivos) > 0): ?>
            <?php foreach ($repuestosInactivos as $r): ?>
                <tr>
                    <td><?php echo $r['id']; ?></td>
                    <td><?php echo htmlspecialchars($r['codigo_pieza']); ?></td>
                    <td><?php echo htmlspecialchars($r['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($r['nombre_categoria']); ?></td>
                    <td><?php echo $r['stock']; ?></td>
                    <td><?php echo number_format($r['precio'], 2); ?></td>
                    <td>
                        <a href="index.php?action=cambiar_estado&id=<?php echo $r['id']; ?>&estado=1"
                            class="btn btn-sm btn-success">Activar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">No hay repuestos inactivos.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
