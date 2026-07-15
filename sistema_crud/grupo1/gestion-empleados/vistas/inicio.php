<?php 
    $empleados = EmpleadoController::listar();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Lista de Empleados</h2>
    <a href="index.php?action=crear" class="btn btn-primary">Nuevo Empleado</a>
</div>
<table class="table table-hover border">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Puesto</th>
            <th>Salario</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($empleados as $e): ?>
            <tr>
                <td><?php echo $e['id']; ?></td>
                <td><?php echo $e['nombre']; ?></td>
                <td><?php echo $e['puesto']; ?></td>
                <td>$<?php echo number_format($e['salario'], 2); ?></td>
                <td>
                    <a href="index.php?action=editar&id=<?php echo $e['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="index.php?action=eliminar&id=<?php echo $e['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar?')">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

