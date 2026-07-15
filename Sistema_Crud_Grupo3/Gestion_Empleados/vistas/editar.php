<?php
$id = $_GET['id'];
$empleado = EmpleadosController::ObtenerPorId($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    EmpleadosController::EditarEmpleado($id, $_POST['nombre'], $_POST['puesto'], $_POST['salario'], $_POST['fecha_ingreso'] );
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Editar Empleado</h2>
    <a href="index.php" class="btn btn-secondary">Volver</a>
</div>

<div class="card">
    <div class="card-body">
        <form  action="index.php?action=editar&id=<?php echo $id; ?>" method="POST">

            <input type="hidden" name="id" value="<?php echo $empleado['id']; ?>">

            <div class="mb-3">
                <label class="form-label fw-bold">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($empleado['nombre']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Puesto</label>
                <input type="text" name="puesto" class="form-control" value="<?php echo htmlspecialchars($empleado['puesto']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Salario</label>
                <input type="number" step="0.01" name="salario" class="form-control" value="<?php echo $empleado['salario']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Fecha de Ingreso</label>
                <input type="date" name="fecha_ingreso" class="form-control" value="<?php echo $empleado['fecha_ingreso']; ?>" required>
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="index.php" class="btn btn-outline-secondary">Cancelar</a>
            </div>

        </form>
    </div>
</div>