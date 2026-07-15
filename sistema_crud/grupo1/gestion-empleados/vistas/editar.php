<?php
$id = $_GET['id'];
$empleado = EmpleadoController::obtenerPorId($id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    EmpleadoController::actualizar($id, $_POST['nombre'], $_POST['puesto'], $_POST['salario']);
}
?>

<h2>Editar Empleado</h2>
<div class="card p-4 shadow-sm mt-3" style="max-width: 600px;">
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nombre Completo</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($empleado['nombre']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Puesto</label>
            <input type="text" name="puesto" class="form-control" value="<?php echo htmlspecialchars($empleado['puesto']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Salario</label>
            <input type="number" step="0.01" name="salario" class="form-control" value="<?php echo htmlspecialchars($empleado['salario']); ?>" required>
        </div>
        <button type="submit" class="btn btn-warning">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
