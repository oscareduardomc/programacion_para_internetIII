<?php
$proyectos = ProyectoController::listarInactivos();
include 'vistas/modulos/alertas.php';
?>

<div class="mb-4">
    <h2 class="mb-0">Administración de Eliminación</h2>
</div>

<div class="alert alert-danger">
    <strong>Advertencia:</strong> Siempre use Hard Delete en proyectos que haya registrados por error.
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Cliente</th>
                <th>Presupuesto</th>
                <th>Fecha Entrega</th>
                <th>Estado</th>
                <th>Activo</th>
                <th>Acción Destructiva</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($proyectos)): ?>
            <tr>
                <td colspan="8" class="text-center text-muted">No hay proyectos para administración.</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($proyectos as $p): ?>
            <tr>
                <td><?php echo $p['id']; ?></td>
                <td><?php echo htmlspecialchars($p['titulo']); ?></td>
                <td><?php echo htmlspecialchars($p['cliente']); ?></td>
                <td>L <?php echo number_format($p['presupuesto'], 2); ?></td>
                <td><?php echo htmlspecialchars($p['fecha_entrega']); ?></td>
                <td><?php echo htmlspecialchars($p['estado_proyecto']); ?></td>
                <td><?php echo $p['activo'] == 1 ? 'Sí' : 'No'; ?></td>
                <td>
                    <a href="index.php?action=hard_delete&id=<?php echo $p['id']; ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('CONFIRMACIÓN DESTRUCTIVA: este proyecto se eliminará definitivamente. ¿Continuar?')">
                        Hard Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
