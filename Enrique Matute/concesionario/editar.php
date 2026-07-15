<?php
// 1. Obtener el id del vehículo por la URL ($_GET)
$id = $_GET['id'];

// 2. Traer los datos actuales del vehículo (consulta preparada)
$sql = "SELECT * FROM vehiculos WHERE id = :id";
$consulta = $conexion->prepare($sql);
$consulta->bindParam(":id", $id);
$consulta->execute();
$vehiculo = $consulta->fetch(PDO::FETCH_ASSOC);

// 3. Cargar las marcas para el <select> dinámico
$sqlMarcas = "SELECT * FROM marcas ORDER BY nombre_marca";
$consultaMarcas = $conexion->prepare($sqlMarcas);
$consultaMarcas->execute();
$marcas = $consultaMarcas->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Vehículo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Editar Vehículo</h2>

        <form action="index.php?action=actualizar" method="POST">

            <!-- 4. Campo oculto con el id (para saber cuál actualizar) -->
            <input type="hidden" name="txtId" value="<?php echo $vehiculo['id']; ?>">

            <div class="mb-3">
                <label>Placa:</label>
                <input type="text" name="txtPlaca" class="form-control"
                       value="<?php echo htmlspecialchars($vehiculo['placa']); ?>" required>
            </div>

            <div class="mb-3">
                <label>Modelo:</label>
                <input type="text" name="txtModelo" class="form-control"
                       value="<?php echo htmlspecialchars($vehiculo['modelo']); ?>" required>
            </div>

            <!-- 5. Select dinámico, marcando la marca actual como seleccionada -->
            <div class="mb-3">
                <label>Marca:</label>
                <select name="txtMarca" class="form-control" required>
                    <?php
                    foreach ($marcas as $marca) {
                        // Si esta marca es la del vehículo, queda seleccionada
                        if ($marca['id'] == $vehiculo['id_marca']) {
                            echo "<option value='" . $marca['id'] . "' selected>" . htmlspecialchars($marca['nombre_marca']) . "</option>";
                        } else {
                            echo "<option value='" . $marca['id'] . "'>" . htmlspecialchars($marca['nombre_marca']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Año:</label>
                <input type="number" name="txtAnio" class="form-control"
                       value="<?php echo $vehiculo['anio']; ?>" required>
            </div>

            <div class="mb-3">
                <label>Precio:</label>
                <input type="number" step="0.01" name="txtPrecio" class="form-control"
                       value="<?php echo $vehiculo['precio']; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="index.php?action=listar" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>