<?php
$id = $_GET['id'];
$vehiculo = VehiculoController::obtener($id);
$marcas = VehiculoController::marcas();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    VehiculoController::actualizar( $id, $_POST['placa'], $_POST['modelo'], $_POST['id_marca'], $_POST['fecha_vehiculo'], $_POST['precio']);
}
?>

<h2>Editar Vehículo</h2>

<div class="card p-4 shadow-sm mt-3" style="max-width: 600px;">
    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Placa</label>
            <input type="text" name="placa" class="form-control"
                value="<?php echo $vehiculo['placa']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Modelo</label>
            <input type="text" name="modelo" class="form-control"
                value="<?php echo $vehiculo['modelo']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Marca</label>
            <select name="id_marca" class="form-select" required>
                <?php foreach ($marcas as $m) { ?>
                    <option value="<?php echo $m['id']; ?>"
                        <?php if ($vehiculo['id_marca'] == $m['id']) echo "selected"; ?>>
                        <?php echo $m['nombre_marca']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha del Vehículo</label>
            <input type="number" name="fecha_vehiculo" class="form-control"
                value="<?php echo $vehiculo['fecha_vehiculo']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control"
                value="<?php echo $vehiculo['precio']; ?>" required>
        </div>

        <button type="submit" class="btn btn-warning">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>

    </form>
</div>