<?php
require "includes/session.php";
require "config/db.php";

$inicio = !empty($_GET['inicio']) ? $conn->real_escape_string($_GET['inicio']) : date('Y-m-01');
$fin    = !empty($_GET['fin'])    ? $conn->real_escape_string($_GET['fin'])    : date('Y-m-d');

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
$total  = 0;

if ($resultado && $resultado->num_rows > 0) {
    while ($venta = $resultado->fetch_assoc()) {
        $ventas[] = $venta;
        $total   += $venta['total'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            background: #fff;
        }

        .encabezado {
            text-align: center;
            margin-bottom: 10px;
        }

        .encabezado h4 {
            margin: 0;
            font-size: 18px;
        }

        .encabezado p {
            margin: 2px 0;
            font-size: 12px;
            color: #555;
        }

        hr {
            border: 0;
            border-top: 1px solid #000;
        }

        .table thead {
            background: #0d6efd;
            color: white;
        }

        .totales {
            text-align: right;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body class="p-3">

    <!-- Encabezado -->
    <div class="encabezado">
        <h4>Punto de Venta</h4>
        <p>Reporte de Ventas</p>
        <p>Período: <?php echo htmlspecialchars($inicio); ?> al <?php echo htmlspecialchars($fin); ?></p>
        <p>Fecha de generación: <?php echo date('d/m/Y H:i:s'); ?></p>
    </div>

    <hr>

    <!-- Resumen -->
    <div class="row mb-3">
        <div class="col-6">
            <strong>Ventas realizadas:</strong> <?php echo count($ventas); ?>
        </div>
        <div class="col-6 text-end">
            <strong>Total vendido:</strong> L. <?php echo number_format($total, 2); ?>
        </div>
    </div>

    <hr>

    <!-- Tabla de ventas -->
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Factura</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Forma de pago</th>
                <th class="text-end">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($ventas)): ?>
                <?php foreach ($ventas as $i => $venta): ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo htmlspecialchars($venta['numero_factura']); ?></td>
                    <td><?php echo htmlspecialchars($venta['fecha']); ?></td>
                    <td><?php echo htmlspecialchars($venta['cliente'] ?? 'Consumidor Final'); ?></td>
                    <td><?php echo htmlspecialchars($venta['forma_pago'] ?? 'Efectivo'); ?></td>
                    <td class="text-end">L. <?php echo number_format($venta['total'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="table-dark fw-bold">
                    <td colspan="5">TOTAL GENERAL</td>
                    <td class="text-end">L. <?php echo number_format($total, 2); ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">No se encontraron ventas en el rango seleccionado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>

    <!-- Botones (no se imprimen) -->
    <div class="no-print d-flex gap-2">
        <button class="btn btn-primary btn-sm" onclick="window.print()">Imprimir</button>
        <a href="reportes.php?inicio=<?php echo urlencode($inicio); ?>&fin=<?php echo urlencode($fin); ?>" class="btn btn-secondary btn-sm">Volver</a>
    </div>

</body>
</html>
