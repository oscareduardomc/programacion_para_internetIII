<?php 
    // Determinar si filtramos por activos o historial
    $soloActivos = true;
    if (isset($_GET['filtro']) && $_GET['filtro'] == 'historial') {
        $soloActivos = false;
    }

    $vehiculos = AutosControlador::enlistarVehiculos($soloActivos);
    $marcas = AutosControlador::enlistarMarcas();
?>

<!-- Filtro Rápido Simple -->
<div class="mb-4">
    <strong>Ver vehículos: </strong>
    <a href="index.php?filtro=activos" class="btn btn-sm <?php echo $soloActivos ? 'btn-success' : 'btn-outline-success'; ?>">
        Solo Activos
    </a>
    <a href="index.php?filtro=historial" class="btn btn-sm <?php echo !$soloActivos ? 'btn-secondary' : 'btn-outline-secondary'; ?>">
        Historial (Inactivos)
    </a>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>LISTA DE VEHÍCULOS (<?php echo $soloActivos ? 'Solo Activos' : 'Inactivos'; ?>)</h2>
    <a href="index.php?action=crear" class="btn btn-primary">NUEVO VEHÍCULO / MARCA</a>
</div>

<table class="table table-hover border">
    <thead class="table-success">
        <tr>
            <th>ID</th>
            <th>PLACA</th>
            <th>MODELO</th>
            <th>MARCA</th>
            <th>AÑO</th>
            <th>PRECIO</th>
            <th>ESTADO</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($vehiculos as $v): ?>
            <tr>
                <td><?php echo $v['id']; ?></td>
                <td><?php echo $v['placa']; ?></td>
                <td><?php echo $v['modelo']; ?></td>
                <td>
                    <?php echo $v['nombre_marca']; ?> 
                    (<?php echo $v['pais_origen']; ?>)
                </td>
                <td><?php echo $v['anio']; ?></td>
                <td>$<?php echo number_format($v['precio'], 2); ?></td>
                <td>
                    <?php if ($v['estado_activo'] == 1): ?>
                        <span>Activo</span>
                    <?php else: ?>
                        <span>Vendido</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="index.php?action=editar&type=vehiculo&id=<?php echo $v['id']; ?>" class="btn btn-warning btn-sm">EDITAR</a>
                    
                    <?php if ($v['estado_activo'] == 1): ?>
                        <a href="index.php?action=desactivar_vehiculo&id=<?php echo $v['id']; ?>" class="btn btn-info btn-sm text-white" onclick="return confirm('¿Seguro que deseas vender este auto?')">VENDER</a>
                    <?php else: ?>
                        <a href="index.php?action=activar_vehiculo&id=<?php echo $v['id']; ?>" class="btn btn-success btn-sm">ACTIVAR</a>
                    <?php endif; ?>

                    <a href="index.php?action=eliminar_vehiculo&id=<?php echo $v['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar?')">ELIMINAR</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<hr class="my-5">


<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>LISTA DE MARCAS</h2>
</div>

<table class="table table-hover border">
    <thead class="table-success">
        <tr>
            <th>ID</th>
            <th>NOMBRE MARCA</th>
            <th>PAÍS ORIGEN</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($marcas as $m): ?>
            <tr>
                <td><?php echo $m['id']; ?></td>
                <td><?php echo htmlspecialchars($m['nombre_marca']); ?></td>
                <td><?php echo htmlspecialchars($m['pais_origen']); ?></td>
                <td>
                    <a href="index.php?action=editar&type=marca&id=<?php echo $m['id']; ?>" class="btn btn-warning btn-sm">EDITAR</a>
                    <a href="index.php?action=eliminar_marca&id=<?php echo $m['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar?')">ELIMINAR</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
