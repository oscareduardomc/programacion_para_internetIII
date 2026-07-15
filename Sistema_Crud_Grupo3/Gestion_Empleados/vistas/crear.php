
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Agregar Empleado</h2>
    <a href="index.php" class="btn btn-secondary">Volver</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="index.php?action=guardar" method="POST">

            <div class="mb-3">
                <label class="form-label fw-bold">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Puesto</label>
                <input type="text" name="puesto" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Salario</label>
                <input type="number" step="0.01" name="salario" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Fecha de Ingreso</label>
                <input type="date" name="fecha_ingreso" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Guardar Empleado</button>
                <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
            </div>

        </form>
    </div>
</div>