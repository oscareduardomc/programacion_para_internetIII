<?php
// 1. Cargar las marcas desde la base para el <select> dinámico
$sqlMarcas = "SELECT * FROM marcas ORDER BY nombre_marca";
$consultaMarcas = $conexion->prepare($sqlMarcas);
$consultaMarcas->execute();
$marcas = $consultaMarcas->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Vehículo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Registrar Nuevo Vehículo</h2>

        <!-- 2. Formulario que envía por POST a guardar -->
        <form action="index.php?action=guardar" method="POST">

            <div class="mb-3">
                <label>Placa:</label>
                <input type="text" name="txtPlaca" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Modelo:</label>
                <input type="text" name="txtModelo" class="form-control" required>
            </div>

            <!-- 3. Select dinámico cargado desde la tabla marcas -->
            <div class="mb-3">
                <label>Marca:</label>
                <select name="txtMarca" class="form-control" required>
                    <option value="">-- Seleccione una marca --</option>
                    <?php
                    foreach ($marcas as $marca) {
                        echo "<option value='" . $marca['id'] . "'>" . htmlspecialchars($marca['nombre_marca']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Año:</label>
                <input type="number" name="txtAnio" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Precio:</label>
                <input type="number" step="0.01" name="txtPrecio" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="index.php?action=listar" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>