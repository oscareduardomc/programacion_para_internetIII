<?php
require "includes/session.php";
require "config/db.php";

// Consultar productos activos para el select
$query_productos = "SELECT id_producto, codigo, nombre, stock, unidad_medida FROM productos WHERE estado = 1 ORDER BY nombre ASC";
$productos = $conn->query($query_productos);

// Consultar historial de movimientos
$query_movimientos = "SELECT m.*, p.nombre AS producto_nombre, p.codigo AS producto_codigo, u.nombre AS usuario_nombre 
                      FROM movimientos_inventario m
                      INNER JOIN productos p ON m.id_producto = p.id_producto
                      INNER JOIN usuarios u ON m.id_usuario = u.id_usuario
                      ORDER BY m.fecha DESC";
$movimientos = $conn->query($query_movimientos);

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";
?>

<div class="content">

    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-<?php echo $_SESSION['tipo']; ?> alert-dismissible fade show" role="alert">
            <?php 
                echo $_SESSION['mensaje']; 
                unset($_SESSION['mensaje']);
                unset($_SESSION['tipo']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-boxes-packing"></i>
            Movimientos de Inventario
        </h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoMovimiento">
            <i class="fa-solid fa-plus"></i>
            Nuevo Movimiento
        </button>
    </div>

    <!-- TABLA DE HISTORIAL DE MOVIMIENTOS -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped id-datatable" id="tablaMovimientos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Stock Anterior</th>
                            <th>Stock Nuevo</th>
                            <th>Motivo</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $movimientos->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id_movimiento']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($row['fecha'])); ?></td>
                                <td><?php echo htmlspecialchars($row['producto_codigo']); ?></td>
                                <td><?php echo htmlspecialchars($row['producto_nombre']); ?></td>
                                <td>
                                    <?php if ($row['tipo_movimiento'] == 'ENTRADA'): ?>
                                        <span class="badge bg-success"><i class="fa-solid fa-arrow-down"></i> ENTRADA</span>
                                    <?php elseif ($row['tipo_movimiento'] == 'SALIDA'): ?>
                                        <span class="badge bg-danger"><i class="fa-solid fa-arrow-up"></i> SALIDA</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark"><i class="fa-solid fa-rotate"></i> AJUSTE</span>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?php echo number_format($row['cantidad'], 2); ?></strong></td>
                                <td><?php echo number_format($row['stock_anterior'], 2); ?></td>
                                <td><?php echo number_format($row['stock_nuevo'], 2); ?></td>
                                <td><?php echo htmlspecialchars($row['motivo']); ?></td>
                                <td><?php echo htmlspecialchars($row['usuario_nombre']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL NUEVO MOVIMIENTO -->
<div class="modal fade" id="modalNuevoMovimiento" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalLabel"><i class="fa-solid fa-right-left"></i> Registrar Movimiento</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="controllers/guardarMovimiento.php" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Producto <span class="text-danger"></span></label>
                            <select name="id_producto" id="id_producto" class="form-control select2" required style="width:100%;">
                                <option value="">Seleccione un producto</option>
                                <?php while ($p = $productos->fetch_assoc()): ?>
                                    <option value="<?php echo $p['id_producto']; ?>">
                                        <?php echo $p['codigo'] . " - " . $p['nombre'] . " (Stock: " . $p['stock'] . ")"; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo de Movimiento <span class="text-danger"></span></label>
                            <select name="tipo_movimiento" class="form-control" required>
                                <option value="">Seleccione una opción</option>
                                <option value="ENTRADA">ENTRADA (+ Stock)</option>
                                <option value="SALIDA">SALIDA (- Stock)</option>
                                <option value="AJUSTE">AJUSTE (Reemplazar Stock)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Cantidad <span class="text-danger"></span></label>
                            <input type="number" step="0.01" min="0.01" class="form-control" name="cantidad" placeholder="0.00" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Motivo / Observación <span class="text-danger"></span></label>
                            <input type="text" class="form-control" name="motivo" placeholder="Ej: Compra a proveedor, Producto dañado, etc." required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Guardar Movimiento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>



<?php include "includes/footer.php"; ?>