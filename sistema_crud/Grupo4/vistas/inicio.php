<?php
$filtro = isset($_GET['filtro_estado']) ? $_GET['filtro_estado'] : '';
$empleados = EmpleadoController::listar($filtro !== '' ? $filtro : null);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="text-success mb-0"><i class="bi bi-people-fill"></i> <strong>Lista de Empleados</strong></h1>
    <div class="d-flex gap-2">
        <form method="GET" class="d-flex gap-2">
            <select name="filtro_estado" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                <option value="" <?php echo $filtro === '' ? 'selected' : ''; ?>>Todos</option>
                <option value="1" <?php echo $filtro === '1' ? 'selected' : ''; ?>>Activos</option>
                <option value="0" <?php echo $filtro === '0' ? 'selected' : ''; ?>>Inactivos</option>
                <option value="2" <?php echo $filtro === '2' ? 'selected' : ''; ?>>Despedidos</option>
            </select>
            <?php if ($filtro !== ''): ?>
                <a href="index.php" class="btn btn-sm btn-outline-secondary">Quitar Filtros</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php if (isset($_GET['mensaje'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php echo htmlspecialchars($_GET['mensaje']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm w-100">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Puesto</th>
                        <th>Salario</th>
                        <th>Fecha Ingreso</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($empleados) && count($empleados) > 0): ?>
                        <?php foreach ($empleados as $emp): ?>
                            <tr>
                                <td><strong><?php echo $emp['id']; ?></strong></td>
                                <td><?php echo htmlspecialchars($emp['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($emp['puesto']); ?></td>
                                <td>L. <?php echo number_format($emp['salario'], 2); ?></td>
                                <td><?php echo $emp['fecha_ingreso']; ?></td>
                                <td>
                                    <?php
                                    $estado = (int)$emp['activo'];
                                    if ($estado === 1):
                                    ?>
                                        <span class="badge bg-success">Activo</span>
                                    <?php elseif ($estado === 0): ?>
                                        <span class="badge bg-warning text-dark">Inactivo</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Despedido</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="index.php?action=editar&id=<?php echo $emp['id']; ?>"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <a href="index.php?action=eliminar&id=<?php echo $emp['id']; ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Seguro que deseas eliminar a <?php echo htmlspecialchars($emp['nombre']); ?>?');">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No hay empleados registrados aún.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
