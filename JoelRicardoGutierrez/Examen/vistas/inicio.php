<?php
$proyectos = ProyectoController::listar();
include 'vistas/modulos/alertas.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0">Proyectos Activos</h2>
    </div>
    <a href="index.php?action=crear" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Proyecto
    </a>
</div>

<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Cliente</th>
                <th>Presupuesto</th>
                <th>Fecha Entrega</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($proyectos)): ?>
            <tr>
                <td colspan="7" class="text-center text-muted">No hay proyectos activos para mostrar.</td>
            </tr>
        <?php endif; ?>
        <?php foreach ($proyectos as $p): ?>
            <tr>
                <td><?php echo $p['id']; ?></td>
                <td><?php echo htmlspecialchars($p['titulo']); ?></td>
                <td><?php echo htmlspecialchars($p['cliente']); ?></td>
                <td>L <?php echo number_format($p['presupuesto'], 2); ?></td>
                <td><?php echo htmlspecialchars($p['fecha_entrega']); ?></td>
                <td><span class="badge bg-success"><?php echo htmlspecialchars($p['estado_proyecto']); ?></span></td>
                <td>
                    <a href="index.php?action=editar&id=<?php echo $p['id']; ?>" class="btn btn-warning btn-sm">
                        Editar
                    </a>
                    <a href="index.php?action=soft_delete&id=<?php echo $p['id']; ?>" class="btn btn-secondary btn-sm"
                       onclick="return confirm('¿Desea marcar este proyecto como inactivo?')">
                        Soft Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
