<?php
$proyectos = ProyectosController::listarInactivos();
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Papelera</h2>
    <a href="index.php" class="btn btn-secondary">Volver</a>
</div>

<?php if ($msg === 'eliminado'): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
         Proyecto eliminado permanentemente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="alert alert-warning">
    Los proyectos aquí listados están <strong>inactivos</strong>.
</div>

<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle">
        <thead class="table-danger">
            <tr>
                <th>#</th>
                <th>Título</th>
                <th>Cliente</th>
                <th>Presupuesto</th>
                <th>Fecha de Entrega</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($proyectos) > 0): ?>
                <?php foreach ($proyectos as $p): ?>
                <tr class="table-secondary">
                    <td><?php echo $p['id']; ?></td>
                    <td><?php echo htmlspecialchars($p['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                    <td>L. <?php echo number_format($p['presupuesto'], 2); ?></td>
                    <td><?php echo $p['fecha_entrega']; ?></td>
                    <td>
                        <a href="index.php?action=eliminar&id=<?php echo $p['id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Eliminar PERMANENTEMENTE el proyecto <?php echo htmlspecialchars($p['titulo']); ?>? Esta acción no se puede deshacer.');">
                             Eliminar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">La papelera está vacía.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
