<?php
$repuestos = respuestosController::listar();
?>

<h2>Repuestos Activos</h2>

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

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Categoria</th>
            <th>Stock</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (is_array($repuestos) && count($repuestos) > 0): ?>
            <?php foreach ($repuestos as $r): ?>
                <tr class="<?php echo ((int)$r['stock'] < 5) ? 'table-warning' : ''; ?>">
                    <td><?php echo $r['id']; ?></td>
                    <td><?php echo htmlspecialchars($r['codigo_pieza']); ?></td>
                    <td><?php echo htmlspecialchars($r['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($r['nombre_categoria']); ?></td>
                    <td><?php echo $r['stock']; ?></td>
                    <td><?php echo number_format($r['precio'], 2); ?></td>
                    <td>
                        <a href="index.php?action=editar&id=<?php echo $r['id']; ?>"
                            class="btn btn-sm btn-warning">Editar</a>
                        <a href="index.php?action=cambiar_estado&id=<?php echo $r['id']; ?>&estado=0"
                            class="btn btn-sm btn-secondary"
                            onclick="return confirm('Desactivar <?php echo htmlspecialchars($r['nombre']); ?>?');">Inactivar</a>
                        <?php if ((int)$r['stock'] === 0): ?>
                            <a href="index.php?action=eliminar&id=<?php echo $r['id']; ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Eliminar <?php echo htmlspecialchars($r['nombre']); ?>?');">Eliminar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">No hay repuestos activos.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
