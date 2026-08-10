<?php
require "includes/session.php";
require "config/db.php";

$inicio = !empty($_GET['inicio']) ? $conn->real_escape_string($_GET['inicio']) : date('Y-m-01');
$fin = !empty($_GET['fin']) ? $conn->real_escape_string($_GET['fin']) : date('Y-m-d');

$sql = "SELECT v.id_venta, 
               v.numero_factura, 
               v.fecha, 
               v.total,
               c.nombre AS cliente, 
               fp.forma_pago
        FROM ventas v
        LEFT JOIN clientes c ON v.id_cliente = c.id_cliente
        LEFT JOIN formas_pago fp ON v.id_forma_pago = fp.id_forma_pago
        WHERE DATE(v.fecha) BETWEEN '$inicio' AND '$fin' AND v.estado = 'ACTIVA'
        ORDER BY v.fecha DESC";

$resultado = $conn->query($sql);

$ventas = [];
$total = 0;

if ($resultado && $resultado->num_rows > 0) {
    while ($venta = $resultado->fetch_assoc()) {
        $ventas[] = $venta;
        $total += $venta['total'];
    }
}

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";
?>

<div class="content">
    <h2><i class="fa-solid fa-chart-column"></i> Reporte de Ventas</h2>

    <div class="card mt-4 p-3">
        <form method="GET" action="reportes.php" class="row g-3 align-items-end" id="formReporte">
            <div class="col-md-4">
                <label class="form-label">Fecha inicial</label>
                <input type="date" name="inicio" id="inputInicio" class="form-control" value="<?php echo htmlspecialchars($inicio); ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Fecha final</label>
                <input type="date" name="fin" id="inputFin" class="form-control" value="<?php echo htmlspecialchars($fin); ?>" required>
            </div>
            <div class="col-md-4 d-flex gap-2">
                
                <button type="button" class="btn btn-primary" id="btnGenerarReporte">
                    <i class="fa-solid fa-file-pdf"></i> Generar reporte
                </button>
            </div>
        </form>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card p-3">
                <h5>Ventas realizadas</h5>
                <h3><?php echo count($ventas); ?></h3>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3">
                <h5>Total vendido</h5>
                <h3>L. <?php echo number_format($total, 2); ?></h3>
            </div>
        </div>
    </div>

    <div class="card mt-4 p-3">
        <h5>Detalle de ventas</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped mt-3 datatable">
                <thead>
                    <tr>
                        <th>Factura</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Forma de pago</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ventas)) { ?>
                        <?php foreach ($ventas as $venta) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($venta['numero_factura']); ?></td>
                                <td><?php echo htmlspecialchars($venta['fecha']); ?></td>
                                <td><?php echo htmlspecialchars($venta['cliente'] ?? 'Consumidor Final'); ?></td>
                                <td><?php echo htmlspecialchars($venta['forma_pago'] ?? 'Efectivo'); ?></td>
                                <td>L. <?php echo number_format($venta['total'], 2); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">No se encontraron ventas en el rango de fechas seleccionado.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById('btnGenerarReporte').addEventListener('click', function () {
    var inicio = document.getElementById('inputInicio').value;
    var fin    = document.getElementById('inputFin').value;

    if (!inicio || !fin) {
        Swal.fire({
            icon: 'warning',
            title: 'Fechas requeridas',
            text: 'Por favor selecciona las fechas de inicio y fin antes de generar el reporte.',
            confirmButtonColor: '#2563eb'
        });
        return;
    }

    if (inicio > fin) {
        Swal.fire({
            icon: 'error',
            title: 'Rango inválido',
            text: 'La fecha inicial no puede ser mayor que la fecha final.',
            confirmButtonColor: '#2563eb'
        });
        return;
    }

    var url = 'imprimirReporte.php?inicio=' + encodeURIComponent(inicio) + '&fin=' + encodeURIComponent(fin);
    window.open(url, '_blank');
});
</script>

<?php include "includes/footer.php"; ?>