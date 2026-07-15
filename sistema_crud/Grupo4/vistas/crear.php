<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resultado = EmpleadoController::guardar($_POST['nombre'], $_POST['puesto'], $_POST['salario']);
    if ($resultado) echo $resultado;
}
?>

<h2 class="text-info"><strong>Registrar nuevo empleado</strong></h2>
<div class="card p-4 shadow mt-3" style="max-width: 600px;">
    <form method="POST" onsubmit="return confirm('¿Seguro que deseas guardar este empleado?');">
        <div class="mb-3">
            <label class="form-label"><strong>Nombre del empleado</strong></label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>Puesto</strong></label>
            <input type="text" name="puesto" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>Salario</strong></label>
            <input type="number" step="0.01" name="salario" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>