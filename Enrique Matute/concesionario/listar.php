<?php
// 1. Determinar el filtro por $_GET (por defecto: solo activos)
$filtro = isset($_GET['estado']) ? $_GET['estado'] : "activos";

// 2. Definir el valor según el filtro elegido
if ($filtro == "inactivos") {
    $valorEstado = 0;
} else {
    $valorEstado = 1;
}

// 3. Consulta con INNER JOIN para mostrar el nombre de la marca (no el id)
$sql = "SELECT vehiculos.id, vehiculos.placa, vehiculos.modelo,
               marcas.nombre_marca, vehiculos.anio, vehiculos.precio
        FROM vehiculos
        INNER JOIN marcas ON vehiculos.id_marca = marcas.id
        WHERE vehiculos.estado_activo = :estado
        ORDER BY vehiculos.id DESC";

$consulta = $conexion->prepare($sql);
$consulta->bindParam(":estado", $valorEstado);
$consulta->execute();
$lista = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vehículos Seminuevos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Vehículos en Exhibición</h2>

        <!-- 4. Alertas capturadas por $_GET -->
        <?php if (isset($_GET['msg'])) { ?>
            <?php if ($_GET['msg'] == "creado") { ?>
                <div class="alert alert-success">Vehículo registrado correctamente.</div>
            <?php } else if ($_GET['msg'] == "actualizado") { ?>
                <div class="alert alert-info">Vehículo actualizado correctamente.</div>
            <?php } else if ($_GET['msg'] == "desactivado") { ?>
                <div class="alert alert-warning">El vehículo fue marcado como vendido.</div>
            <?php } else if ($_GET['msg'] == "eliminado") { ?>
                <div class="alert alert-danger">Vehículo eliminado permanentemente.</div>
            <?php } else if ($_GET['msg'] == "error") { ?>
                <div class="alert alert-danger">Ocurrió un error. Verifique los datos.</div>
            <?php } ?>
        <?php } ?>

        <!-- 5. Botones de filtro y nuevo -->
        <a href="index.php?action=crear" class="btn btn-primary mb-3">Nuevo Vehículo</a>
        <a href="index.php?action=listar&estado=activos" class="btn btn-outline-success mb-3">En Exhibición</a>
        <a href="index.php?action=listar&estado=inactivos" class="btn btn-outline-secondary mb-3">Vendidos</a>

        <!-- 6. Tabla de vehículos -->
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Placa</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Año</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 7. Recorrer cada vehículo
                if (count($lista) > 0) {
                    foreach ($lista as $fila) {
                        echo "<tr>";
                        echo "<td>" . $fila['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($fila['placa']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['modelo']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['nombre_marca']) . "</td>";
                        echo "<td>" . $fila['anio'] . "</td>";
                        echo "<td>$" . $fila['precio'] . "</td>";
                        echo "<td>";
                        echo "<a href='index.php?action=editar&id=" . $fila['id'] . "' class='btn btn-warning btn-sm'>Editar</a> ";
                        // Soft delete
                        echo "<a href='index.php?action=desactivar&id=" . $fila['id'] . "' class='btn btn-secondary btn-sm'>Marcar como Vendido</a> ";
                        // Hard delete con confirmación
                        echo "<a href='index.php?action=eliminar&id=" . $fila['id'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('¿Eliminar permanentemente?')\">Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No hay vehículos en esta categoría.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>