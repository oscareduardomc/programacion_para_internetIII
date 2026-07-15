<?php
$marcas = VehiculoController::marcas();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    VehiculoController::guardar( $_POST['placa'], $_POST['modelo'], $_POST['id_marca'], $_POST['fecha_vehiculo'], $_POST['precio']);
}
?>

<h2>Agregar Nuevo Vehículo</h2>

<div class="card p-4 shadow-sm mt-3" style="max-width: 600px;">
    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Placa</label>
            <input type="text" name="placa" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Modelo</label>
            <input type="text" name="modelo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Marca</label>
            <select name="id_marca" class="form-select" required>
                <?php foreach ($marcas as $m) { ?>
                    <option value="<?php echo $m['id']; ?>">
                        <?php echo $m['nombre_marca']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Año del vehículo</label>
            <input type="number" name="fecha_vehiculo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>

    </form>
</div>