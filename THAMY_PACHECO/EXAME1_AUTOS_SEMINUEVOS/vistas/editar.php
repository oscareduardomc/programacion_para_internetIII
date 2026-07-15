<?php
$id = $_GET['id'];
$type = isset($_GET['type']) ? $_GET['type'] : 'vehiculo';

if ($type == 'marca') {
    $marca = AutosControlador::obtenerPorIdMarca($id);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        AutosControlador::ACTUALIZAR_MARCA($id, $_POST['nombre_marca'], $_POST['pais_origen']);
    }
} else {
    $vehiculo = AutosControlador::obtenerPorIdVehiculo($id);
    $marcas = AutosControlador::enlistarMarcas();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        AutosControlador::ACTUALIZAR_VEHICULO($id, $_POST['placa'], $_POST['modelo'], $_POST['id_marca'], $_POST['anio'], $_POST['precio']);
    }
}
?>

<?php if ($type == 'marca'): ?>
    <h2>EDITAR DATOS DE LA MARCA</h2>
    <div class="card p-4 shadow-sm mt-3" style="max-width: 600px;">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">NOMBRE DE LA MARCA</label>
                <input type="text" name="nombre_marca" class="form-control" value="<?php echo $marca['nombre_marca']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">PAÍS DE ORIGEN</label>
                <input type="text" name="pais_origen" class="form-control" value="<?php echo $marca['pais_origen']; ?>" required>
            </div>
            
            <button type="submit" class="btn btn-warning">ACTUALIZAR</button>
            <a href="index.php" class="btn btn-secondary">CANCELAR</a>
        </form>
    </div>
<?php else: ?>
    <h2>EDITAR DATOS DEL VEHÍCULO</h2>
    <div class="card p-4 shadow-sm mt-3" style="max-width: 600px;">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">NÚMERO DE PLACA</label>
                <input type="text" name="placa" class="form-control text-uppercase" value="<?php echo $vehiculo['placa']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">MODELO</label>
                <input type="text" name="modelo" class="form-control" value="<?php echo $vehiculo['modelo']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">MARCA</label>
                <select name="id_marca" class="form-select" required>
                    <?php foreach ($marcas as $m): ?>
                        <option value="<?php echo $m['id']; ?>" <?php echo ($m['id'] == $vehiculo['id_marca']) ? 'selected' : ''; ?>>
                            <?php echo $m['nombre_marca']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">AÑO</label>
                <input type="number" name="anio" class="form-control" value="<?php echo $vehiculo['anio']; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">PRECIO</label>
                <input type="number" step="0.01" name="precio" class="form-control" value="<?php echo $vehiculo['precio']; ?>" required>
            </div>
            
            <button type="submit" class="btn btn-warning">ACTUALIZAR</button>
            <a href="index.php" class="btn btn-secondary">CANCELAR</a>
        </form>
    </div>
<?php endif; ?>