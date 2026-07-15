<?php
$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resultado = EmpleadoController::actualizar($id, $_POST['nombre'], $_POST['puesto'], $_POST['salario'], $_POST['activo']);
    if ($resultado) echo $resultado;
}

$empleado = EmpleadoController::obtenerPorId($id);
$estado = (int)$empleado['activo'];
?>

<h2><strong>Editar Empleado</strong></h2>
<div class="card p-4 shadow mt-3" style="max-width: 600px;">
    <form method="POST" onsubmit="return confirm('¿Seguro que deseas actualizar este empleado?');">
        <div class="mb-3">
            <label class="form-label"><strong>Nombre del empleado</strong></label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $empleado['nombre']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>Puesto</strong></label>
            <input type="text" name="puesto" class="form-control" value="<?php echo $empleado['puesto']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>Salario</strong></label>
            <input type="number" step="0.01" name="salario" class="form-control" value="<?php echo $empleado['salario']; ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>Estado</strong></label>
            <select name="activo" class="form-select">
                <option value="1" <?php echo $estado === 1 ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo $estado === 0 ? 'selected' : ''; ?>>Inactivo</option>
                <option value="2" <?php echo $estado === 2 ? 'selected' : ''; ?>>Despedido</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>