<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['guardar_marca'])) {
        AutosControlador::GUARDAR_MARCA($_POST['nombre_marca'], $_POST['pais_origen']);
    } elseif (isset($_POST['guardar_vehiculo'])) {
        AutosControlador::GUARDAR_VEHICULO($_POST['placa'], $_POST['modelo'], $_POST['id_marca'], $_POST['anio'], $_POST['precio']);
    }
}

// Cargar marcas para el selector
$marcas = AutosControlador::enlistarMarcas();
?>

<div class="row">
    
    <div class="col-md-6 mb-4">
        <h3>Registrar Nueva Marca</h3>
        <form method="POST" action="index.php?action=crear">
            <div class="mb-3">
                <label for="nombre_marca" class="form-label">Nombre de la Marca</label>
                <input type="text" id="nombre_marca" name="nombre_marca" class="form-control" placeholder="Ej. Ford" required>
            </div>
            <div class="mb-3">
                <label for="pais_origen" class="form-label">País de Origen</label>
                <input type="text" id="pais_origen" name="pais_origen" class="form-control" placeholder="Ej. EE.UU." required>
            </div>
            <button type="submit" name="guardar_marca" class="btn btn-primary">
                Guardar Marca
            </button>
        </form>
    </div>

   
    <div class="col-md-6 mb-4">
        <h3>Registrar Nuevo Vehículo</h3>
        <form method="POST" action="index.php?action=crear">
            <div class="mb-3">
                <label for="placa" class="form-label">Número de Placa</label>
                <input type="text" id="placa" name="placa" class="form-control text-uppercase" placeholder="ABC-1234" required <?php echo count($marcas) === 0 ? 'disabled' : ''; ?>>
            </div>

            <div class="mb-3">
                <label for="modelo" class="form-label">Modelo</label>
                <input type="text" id="modelo" name="modelo" class="form-control" placeholder="Ej. Fiesta" required <?php echo count($marcas) === 0 ? 'disabled' : ''; ?>>
            </div>

            <div class="mb-3">
                <label for="id_marca" class="form-label">Marca</label>
                <select id="id_marca" name="id_marca" class="form-select" required <?php echo count($marcas) === 0 ? 'disabled' : ''; ?>>
                    <option value="" disabled selected>-- Seleccionar Marca --</option>
                    <?php foreach ($marcas as $m): ?>
                        <option value="<?php echo $m['id']; ?>">
                            <?php echo htmlspecialchars($m['nombre_marca']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="anio" class="form-label">Año</label>
                <input type="number" id="anio" name="anio" class="form-control" placeholder="Ej. 2015" required <?php echo count($marcas) === 0 ? 'disabled' : ''; ?>>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" step="0.01" id="precio" name="precio" class="form-control" placeholder="Ej. 150000" required <?php echo count($marcas) === 0 ? 'disabled' : ''; ?>>
            </div>

            <button type="submit" name="guardar_vehiculo" class="btn btn-success" <?php echo count($marcas) === 0 ? 'disabled' : ''; ?>>
                Guardar Vehículo
            </button>
        </form>
    </div>
</div>

<div class="mt-3">
    <a href="index.php" class="btn btn-secondary">Regresar</a>
</div>