<?php
$clientes = ClienteController::listarActivos();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ProyectoController::guardar($_POST);
}
include 'vistas/modulos/alertas.php';
?>

<h2>Agregar Nuevo Proyecto</h2>
<div class="card p-4 shadow-sm mt-3" style="max-width: 760px;">
    <form method="POST" novalidate>
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" required minlength="3">
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="1" required minlength="5"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Cliente</label>
            <select name="id_cliente" class="form-select" required>
                <option value="">Seleccione un cliente</option>
                <?php foreach ($clientes as $c): ?>
                    <option value="<?php echo $c['id']; ?>">
                        <?php echo htmlspecialchars($c['nombre_empresa']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Presupuesto</label>
                <input type="number" step="0.01" min="0.01" name="presupuesto" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Fecha de Entrega</label>
                <input type="date" name="fecha_entrega" class="form-control" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado del Proyecto</label>
            <select name="estado_proyecto" class="form-select" required>
                <option value="En desarrollo">En Proceso</option>
                <option value="Pausado">Pausado</option>
                <option value="Cancelado">Cancelado</option>
                <option value="Finalizado">Finalizado</option>
            </select>
            <small class="text-muted">Los proyectos pausados o cancelados no aparecerán en la vista principal.</small>
        </div>

        <button type="submit" class="btn btn-success">Guardar Proyecto</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
