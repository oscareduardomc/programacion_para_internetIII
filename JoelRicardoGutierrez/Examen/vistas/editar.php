<?php
$id = $_GET['id'] ?? null;
$proyecto = ProyectoController::obtenerPorId($id);
$clientes = ClienteController::listarActivos();

if (!$proyecto) {
    echo '<div class="alert alert-danger">Proyecto no encontrado.</div>';
    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ProyectoController::actualizar($id, $_POST);
}
include 'vistas/modulos/alertas.php';
?>

<h2>Editar Proyecto</h2>
<div class="card p-4 shadow-sm mt-3" style="max-width: 760px;">
    <form method="POST" novalidate>
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required minlength="3"
                   value="<?php echo htmlspecialchars($proyecto['titulo']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3" required minlength="5"><?php echo htmlspecialchars($proyecto['descripcion']); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Cliente</label>
            <select name="id_cliente" class="form-select" required>
                <option value="">Seleccione un cliente</option>
                <?php foreach ($clientes as $c): ?>
                    <option value="<?php echo $c['id']; ?>" <?php echo $c['id'] == $proyecto['id_cliente'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($c['nombre_empresa']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Presupuesto</label>
                <input type="number" step="0.01" min="0.01" name="presupuesto" class="form-control" required
                       value="<?php echo htmlspecialchars($proyecto['presupuesto']); ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Fecha de Entrega</label>
                <input type="date" name="fecha_entrega" class="form-control" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>"
                       value="<?php echo htmlspecialchars($proyecto['fecha_entrega']); ?>">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado del Proyecto</label>
            <select name="estado_proyecto" class="form-select" required>
                <?php foreach (['En Proceso', 'Pausado', 'Cancelado', 'Finalizado'] as $estado): ?>
                    <option value="<?php echo $estado; ?>" <?php echo $estado === $proyecto['estado_proyecto'] ? 'selected' : ''; ?>>
                        <?php echo $estado; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-warning">Actualizar Proyecto</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
