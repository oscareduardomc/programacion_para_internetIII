<?php
$estado = isset($_GET['estado']) ? $_GET['estado'] : 1;
$vehiculos = VehiculoController::listar($estado);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Lista de Vehículos</h2>
    <div>
        <a href="index.php?estado=1" class="btn btn-success">Activos</a>
        <a href="index.php?estado=0" class="btn btn-secondary">Historial</a>
        <a href="index.php?action=crear" class="btn btn-primary">Nuevo Vehículo</a>
    </div>
</div>

<table class="table table-hover border">
    <thead class="table-dark">
        <tr>
            <th>Placa</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Modelo del año</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($vehiculos as $v): ?>
            <tr>
                <td><?php echo $v['placa']; ?></td>
                <td><?php echo $v['modelo']; ?></td>
                <td><?php echo $v['nombre_marca']; ?></td>
                <td><?php echo $v['fecha_vehiculo']; ?></td>
                <td><?php echo number_format($v['precio'], 2); ?></td>
                <td>

                    <a href="index.php?action=editar&id=<?php echo $v['id']; ?>" class="btn btn-warning btn-sm"> Editar </a>

                    <?php if ($estado == 1): ?>
                        <a href="index.php?action=vender&id=<?php echo $v['id']; ?>" class="btn btn-info btn-sm"> Vendido </a>
                    <?php endif; ?>

                    <?php if ($estado == 0): ?>
                        <a href="index.php?action=eliminar&id=<?php echo $v['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar?')"> Eliminar</a>
                    <?php endif; ?>

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>