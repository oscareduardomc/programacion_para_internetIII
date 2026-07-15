<?php
$id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$proyecto = ProyectosController::obtenerPorId($id);
$clientes = ProyectosController::listarClientes();
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';

if (!$proyecto) {
    header("Location: index.php");
    exit;
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Editar Proyecto</h2>
    <a href="index.php" class="btn btn-secondary">Volver</a>
</div>

<?php if ($msg === 'error_vacios'): ?>
    <div class="alert alert-danger">Todos los campos son obligatorios.</div>
<?php elseif ($msg === 'error_presupuesto'): ?>
    <div class="alert alert-danger">El presupuesto debe ser un número mayor a cero.</div>
<?php elseif ($msg === 'error_cliente'): ?>
    <div class="alert alert-danger">Debe seleccionar un cliente válido.</div>
<?php elseif ($msg === 'error_fecha'): ?>
    <div class="alert alert-danger">La fecha de entrega debe ser posterior a la fecha actual.</div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="index.php?action=actualizar" method="POST">

            <input type="hidden" name="id" value="<?php echo $proyecto['id']; ?>">

            <div class="mb-3">
                <label class="form-label fw-bold">Título del Proyecto</label>
                <input type="text" name="titulo" class="form-control"
                       value="<?php echo htmlspecialchars($proyecto['titulo']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3" required><?php
                    echo htmlspecialchars($proyecto['descripcion']);
                ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Cliente</label>
                <select name="id_cliente" class="form-select" required>
                    <option value="">-- Seleccione un cliente --</option>
                    <?php foreach ($clientes as $c): ?>
                        <option value="<?php echo $c['id']; ?>"
                            <?php echo ($c['id'] == $proyecto['id_cliente']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($c['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Presupuesto (L.)</label>
                <input type="number" step="0.01" min="0.01" name="presupuesto" class="form-control"
                       value="<?php echo $proyecto['presupuesto']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Fecha de Entrega</label>
                <input type="date" name="fecha_entrega" class="form-control"
                       value="<?php echo $proyecto['fecha_entrega']; ?>"
                       min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                <small class="text-muted">Debe ser posterior a hoy.</small>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">
                     Actualizar
                </button>
                <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
            </div>

        </form>
    </div>
</div>
