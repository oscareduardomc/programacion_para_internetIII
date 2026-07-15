<?php
require_once ('./controladores/EmpleadosController.php');
$empleados = EmpleadosController::listar();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Lista de Empleados</h2>
    <a href="index.php?action=crear" class="btn btn-primary">+ Agregar Empleado</a>
</div>

<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Puesto</th>
                <th>Salario</th>
                <th>Fecha de Ingreso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
              <?php if (count($empleados) > 0): ?>
              <?php foreach ($empleados as $empleado): ?>
                    <tr>
                        <td><?php echo $empleado['id']; ?></td>
                        <td><?php echo htmlspecialchars($empleado['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($empleado['puesto']); ?></td>
                        <td>L. <?php echo number_format($empleado['salario'], 2); ?></td>
                        <td><?php echo $empleado['fecha_ingreso']; ?></td>
                        <td>
                            <a href="index.php?action=editar&id=<?php echo $empleado['id']; ?>"
                               class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <!-- Botón Eliminar con confirmación -->
                            <a href="index.php?action=eliminar&id=<?php echo $empleado['id']; ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Estás seguro de que deseas eliminar a <?php echo htmlspecialchars($empleado['nombre']); ?>?');">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">No hay empleados registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>