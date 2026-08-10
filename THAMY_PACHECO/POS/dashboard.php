<?php
require "includes/session.php";
require "config/db.php";

include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";

 
/* ===========================
   INDICADORES DEL DASHBOARD
   =========================== */

// Ventas de hoy
$sql = "SELECT COALESCE(SUM(total),0) total
        FROM ventas
        WHERE estado='ACTIVA'
        AND DATE(fecha)=CURDATE()";
$ventas_hoy = $conn->query($sql)->fetch_assoc()['total'];

// Ventas del mes
$sql = "SELECT COALESCE(SUM(total),0) total
        FROM ventas
        WHERE estado='ACTIVA'
        AND MONTH(fecha)=MONTH(CURDATE())
        AND YEAR(fecha)=YEAR(CURDATE())";
$ventas_mes = $conn->query($sql)->fetch_assoc()['total'];

// Productos
$sql = "SELECT COUNT(*) total FROM productos WHERE estado=1";
$total_productos = $conn->query($sql)->fetch_assoc()['total'];

// Clientes
$sql = "SELECT COUNT(*) total FROM clientes WHERE estado=1";
$total_clientes = $conn->query($sql)->fetch_assoc()['total'];

// Usuarios
$sql = "SELECT COUNT(*) total FROM usuarios WHERE estado=1";
$total_usuarios = $conn->query($sql)->fetch_assoc()['total'];

// Stock bajo
$sql = "SELECT COUNT(*) total
        FROM productos
        WHERE estado=1
        AND stock <= stock_minimo";
$stock_bajo = $conn->query($sql)->fetch_assoc()['total'];

// Últimas ventas
$sql = "SELECT
            v.numero_factura,
            c.nombre AS cliente,
            v.total,
            v.fecha
        FROM ventas v
        LEFT JOIN clientes c
            ON c.id_cliente=v.id_cliente
        WHERE v.estado='ACTIVA'
        ORDER BY v.id_venta DESC
        LIMIT 10";

$ultimas_ventas = $conn->query($sql);

// Estado de caja
$sql = "SELECT *
        FROM aperturas_caja
        ORDER BY id_apertura DESC
        LIMIT 1";

$caja = $conn->query($sql)->fetch_assoc();
?>
 

<style>
    .card-dashboard{
        border:none;
        border-radius:12px;
        box-shadow:0 0 10px rgba(0,0,0,.08);
    }

    .icono{
        font-size:35px;
        opacity:25;
    }
</style>

<div class="content-wrapper">

    <section class="content pt-4">

        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-dashboard">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Ventas Hoy</h6>
                                    <h3>L <?php echo number_format($ventas_hoy,2); ?></h3>
                                </div>
                                <i class="fa-solid fa-cash-register icono text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-dashboard">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Productos</h6>
                                    <h3><?php echo $total_productos; ?></h3>
                                </div>
                                <i class="fa-solid fa-box icono text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-dashboard">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Clientes</h6>
                                    <h3><?php echo $total_clientes; ?></h3>
                                </div>
                                <i class="fa-solid fa-users icono text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-dashboard">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Stock Bajo</h6>
                                    <h3><?php echo $stock_bajo; ?></h3>
                                </div>
                                <i class="fa-solid fa-triangle-exclamation icono text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
<div class="col-lg-3 col-md-6 mb-3">

    <div class="card card-dashboard bg-info text-white">

        <div class="card-body">

            <div class="d-flex justify-content-between">

                <div>

                    <h6>Ventas del Mes</h6>

                    <h3>L <?php echo number_format($ventas_mes,2); ?></h3>

                </div>

                <i class="fa-solid fa-chart-line fa-2x"></i>

            </div>

        </div>

    </div>

</div>
<div class="col-lg-3 col-md-6 mb-3">

    <div class="card card-dashboard bg-dark text-white">

        <div class="card-body">

            <div class="d-flex justify-content-between">

                <div>

                    <h6>Usuarios</h6>

                    <h3><?php echo $total_usuarios; ?></h3>

                </div>

                <i class="fa-solid fa-user-group fa-2x"></i>

            </div>

        </div>

    </div>

</div>
            </div>

            <div class="row">

                <div class="col-lg-8">

                    <div class="card card-dashboard">

                        <div class="card-header">
                            <strong>Últimas Ventas</strong>
                        </div>

                        <div class="card-body">

                            <table class="table table-bordered table-hover">

                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Cliente</th>
                                        <th>Total</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>

                                <tbody>

<?php if($ultimas_ventas->num_rows > 0){ ?>

    <?php while($row = $ultimas_ventas->fetch_assoc()){ ?>

    <tr>

        <td><?php echo $row['numero_factura']; ?></td>

        <td><?php echo $row['cliente'] ?? 'Consumidor Final'; ?></td>

        <td>L <?php echo number_format($row['total'],2); ?></td>

        <td><?php echo date('d/m/Y H:i', strtotime($row['fecha'])); ?></td>

    </tr>

    <?php } ?>

<?php }else{ ?>

<tr>

    <td colspan="4" class="text-center">

        No hay ventas registradas.

    </td>

</tr>

<?php } ?>

</tbody>

                            </table>

                        </div>

                    </div>

                </div>

                <div class="col-lg-4">

                    <div class="card card-dashboard">

                        <div class="card-header">
                            <strong>Información del Usuario</strong>
                        </div>

                        <div class="card-body">

                           <p><strong>Usuario:</strong> <?php echo $_SESSION['nombre']; ?></p>

<p><strong>Rol:</strong> <?php echo $_SESSION['nombre_rol']; ?></p>

<p><strong>Login:</strong> <?php echo $_SESSION['usuario']; ?></p>

<hr>

<?php if($caja){ ?>

<p>

<strong>Caja:</strong>

<span class="badge bg-<?php echo $caja['estado']=='ABIERTA' ? 'success':'danger'; ?>">

<?php echo $caja['estado']; ?>

</span>

</p>

<p><strong>Apertura:</strong> <?php echo $caja['fecha_apertura']; ?></p>

<p><strong>Monto Inicial:</strong> L <?php echo number_format($caja['monto_inicial'],2); ?></p>

<?php } ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

<?php include "includes/footer.php"; ?>