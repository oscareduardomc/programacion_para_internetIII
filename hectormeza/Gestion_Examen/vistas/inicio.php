<?php
$proyectos = ProyectosController::listar();
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Lista de Proyectos</h2>
    <a href="index.php?action=crear" class="btn btn-primary">
         Nuevo Proyecto
    </a>
</div>

<?php if ($msg === 'guardado'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
         Proyecto guardado exitosamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php elseif ($msg === 'actualizado'): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
         Proyecto actualizado exitosamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php elseif ($msg === 'pausado'): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
         Proyecto movido a la papelera.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Título</th>
                <th>Cliente</th>
                <th>Presupuesto</th>
                <th>Fecha de Entrega</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($proyectos) > 0): ?>
                <?php foreach ($proyectos as $p): ?>
                <tr>
                    <td><?php echo $p['id']; ?></td>
                    <td><?php echo htmlspecialchars($p['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                    <td>L. <?php echo number_format($p['presupuesto'], 2); ?></td>
                    <td><?php echo $p['fecha_entrega']; ?></td>
                    <td>
                        <a href="index.php?action=editar&id=<?php echo $p['id']; ?>"
                           class="btn btn-warning btn-sm">
                             Editar
                        </a>
                        <a href="index.php?action=pausar&id=<?php echo $p['id']; ?>"
                           class="btn btn-secondary btn-sm"
                           onclick="return confirm('¿Pausar el proyecto <?php echo htmlspecialchars($p['titulo']); ?>? Se moverá a la papelera.');">
                             Pausar
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">No hay proyectos activos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
