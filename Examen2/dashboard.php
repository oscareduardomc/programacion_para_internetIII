<?php
require "includes/session.php";
require "config/db.php";

include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";


/* ===========================
   INDICADORES DEL DASHBOARD
   =========================== */

$id = $_SESSION['id'];
$rol = $_SESSION['rol'];

if ($rol === 'usuario') {

    // Total
    $sql = "SELECT COUNT(*) total FROM tickets WHERE id_usuario = $id";
    $total = $conn->query($sql)->fetch_assoc()['total'];

    // Pendientes
    $sql = "SELECT COUNT(*) total FROM tickets WHERE id_usuario = $id AND estado = 'Pendiente'";
    $pendiente = $conn->query($sql)->fetch_assoc()['total'];

    // En Proceso
    $sql = "SELECT COUNT(*) total FROM tickets WHERE id_usuario = $id AND estado = 'En Proceso'";
    $proceso = $conn->query($sql)->fetch_assoc()['total'];

    // Resueltos
    $sql = "SELECT COUNT(*) total FROM tickets WHERE id_usuario = $id AND estado = 'Resuelto'";
    $resuelto = $conn->query($sql)->fetch_assoc()['total'];

} else {

    // Total
    $sql = "SELECT COUNT(*) total FROM tickets";
    $total = $conn->query($sql)->fetch_assoc()['total'];

    // Pendientes
    $sql = "SELECT COUNT(*) total FROM tickets WHERE estado = 'Pendiente'";
    $pendiente = $conn->query($sql)->fetch_assoc()['total'];

    // En Proceso
    $sql = "SELECT COUNT(*) total FROM tickets WHERE estado = 'En Proceso'";
    $proceso = $conn->query($sql)->fetch_assoc()['total'];

    // Resueltos
    $sql = "SELECT COUNT(*) total FROM tickets WHERE estado = 'Resuelto'";
    $resuelto = $conn->query($sql)->fetch_assoc()['total'];

}
?>
 

<style>
    .card-dashboard{
        border:none;
        border-radius:12px;
        box-shadow:0 0 10px rgba(0,0,0,.08);
    }

    .icono{
        font-size:35px;
        opacity:.25;
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
                                    <h6 class="text-muted">Total Tickets</h6>
                                    <h3><?php echo $total; ?></h3>
                                </div>
                                <i class="fa-solid fa-ticket icono text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-dashboard">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Pendientes</h6>
                                    <h3><?php echo $pendiente; ?></h3>
                                </div>
                                <i class="fa-solid fa-clock icono text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-dashboard">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">En Proceso</h6>
                                    <h3><?php echo $proceso; ?></h3>
                                </div>
                                <i class="fa-solid fa-spinner icono text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card card-dashboard">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted">Resueltos</h6>
                                    <h3><?php echo $resuelto; ?></h3>
                                </div>
                                <i class="fa-solid fa-circle-check icono text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </section>

</div>

<?php include "includes/footer.php"; ?>