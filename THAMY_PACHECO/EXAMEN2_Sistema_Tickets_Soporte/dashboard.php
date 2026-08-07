<?php
require "includes/session.php";
require "config/db.php";

$id_usuario = $_SESSION['id_usuario'];
$rol = $_SESSION['rol'];

$where_rol = ($rol === 'usuario') ? " WHERE id_usuario = '$id_usuario'" : "";
$where_and = ($rol === 'usuario') ? " AND id_usuario = '$id_usuario'" : "";

// 1. Total Tickets
$sql = "SELECT COUNT(*) AS total FROM tickets" . $where_rol;
$res = $conn->query($sql);
$total_tickets = ($res) ? $res->fetch_assoc()['total'] : 0;

// 2. Pendientes
$sql = "SELECT COUNT(*) AS total FROM tickets WHERE estado = 'Pendiente'" . $where_and;
$res = $conn->query($sql);
$total_pendientes = ($res) ? $res->fetch_assoc()['total'] : 0;

// 3. En Proceso
$sql = "SELECT COUNT(*) AS total FROM tickets WHERE estado = 'En Proceso'" . $where_and;
$res = $conn->query($sql);
$total_enproceso = ($res) ? $res->fetch_assoc()['total'] : 0;

// 4. Resueltos
$sql = "SELECT COUNT(*) AS total FROM tickets WHERE estado = 'Resuelto'" . $where_and;
$res = $conn->query($sql);
$total_resueltos = ($res) ? $res->fetch_assoc()['total'] : 0;

// Obtener Últimos Tickets Registrados (Máximo 5)
if ($rol === 'tecnico') {
    $sql_ultimos = "SELECT t.*, u.nombre AS solicitante 
                    FROM tickets t 
                    INNER JOIN usuarios u ON t.id_usuario = u.id 
                    ORDER BY t.id DESC LIMIT 5";
} else {
    $sql_ultimos = "SELECT t.*, u.nombre AS solicitante 
                    FROM tickets t 
                    INNER JOIN usuarios u ON t.id_usuario = u.id 
                    WHERE t.id_usuario = '$id_usuario' 
                    ORDER BY t.id DESC LIMIT 5";
}
$ultimos_tickets = $conn->query($sql_ultimos);

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";
?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            Dashboard de Indicadores
        </h2>
        <div>
            <?php if ($rol === 'tecnico') { ?>
                <a href="nuevoUsuario.php" class="btn btn-outline-primary shadow-sm me-2">
                    <i class="fa-solid fa-user-plus me-1"></i> Registrar Usuario
                </a>
            <?php } ?>
            <a href="nuevoTicket.php" class="btn btn-primary shadow-sm">
                <i class="fa-solid fa-plus-circle me-1"></i> Crear Nuevo Ticket
            </a>
        </div>
    </div>

    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?php echo $_SESSION['tipo'] ?? 'info'; ?> alert-dismissible fade show shadow-sm mb-4">
            <i class="fa-solid fa-circle-check me-2"></i>
            <?php echo $_SESSION['mensaje']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php 
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
        }
        ?>

    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-dashboard border-start border-primary border-4">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-bold text-uppercase mb-1" style="font-size: 0.8rem;">Total Tickets</h6>
                            <h2 class="fw-bold mb-0 text-dark"><?php echo $total_tickets; ?></h2>
                        </div>
                        <i class="fa-solid fa-ticket-simple icono text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-dashboard border-start border-warning border-4">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-bold text-uppercase mb-1" style="font-size: 0.8rem;">Pendientes</h6>
                            <h2 class="fw-bold mb-0 text-warning"><?php echo $total_pendientes; ?></h2>
                        </div>
                        <i class="fa-solid fa-clock-rotate-left icono text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-dashboard border-start border-info border-4">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-bold text-uppercase mb-1" style="font-size: 0.8rem;">En Proceso</h6>
                            <h2 class="fw-bold mb-0 text-info"><?php echo $total_enproceso; ?></h2>
                        </div>
                        <i class="fa-solid fa-gears icono text-info"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card card-dashboard border-start border-success border-4">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-bold text-uppercase mb-1" style="font-size: 0.8rem;">Resueltos</h6>
                            <h2 class="fw-bold mb-0 text-success"><?php echo $total_resueltos; ?></h2>
                        </div>
                        <i class="fa-solid fa-circle-check icono text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <strong class="text-primary fs-6">Últimos Tickets Registrados</strong>
                    
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Solicitante</th>
                                    <th>Título</th>
                                    <th>Prioridad</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($ultimos_tickets && $ultimos_tickets->num_rows > 0) { ?>
                                    <?php while ($row = $ultimos_tickets->fetch_assoc()) { ?>
                                        <tr>
                                            <td><strong>#<?php echo $row['id']; ?></strong></td>
                                            <td><?php echo htmlspecialchars($row['solicitante']); ?></td>
                                            <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                                            <td>
                                                <?php
                                                $badgePrio = "badge-prioridad-media";
                                                if ($row['prioridad'] === 'Alta') $badgePrio = "badge-prioridad-alta";
                                                if ($row['prioridad'] === 'Baja') $badgePrio = "badge-prioridad-baja";
                                                ?>
                                                <span class="badge <?php echo $badgePrio; ?>">
                                                    <?php echo $row['prioridad']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php
                                                $badgeEst = "badge-estado-pendiente";
                                                if ($row['estado'] === 'En Proceso') $badgeEst = "badge-estado-enproceso";
                                                if ($row['estado'] === 'Resuelto') $badgeEst = "badge-estado-resuelto";
                                                ?>
                                                <span class="badge <?php echo $badgeEst; ?>">
                                                    <?php echo $row['estado']; ?>
                                                </span>
                                            </td>
                                            <td><small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($row['fecha_creacion'])); ?></small></td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">No hay tickets registrados en el sistema.</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <strong class="text-primary fs-6"><i class="fa-solid fa-id-card me-2"></i>Información del Usuario</strong>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['nombre']); ?></p>
                    <p class="mb-2"><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                    <p class="mb-3"><strong>Perfil / Rol:</strong> 
                        <span class="badge <?php echo ($rol === 'tecnico') ? 'bg-danger' : 'bg-primary'; ?>">
                            <?php echo ucfirst($rol); ?>
                        </span>
                    </p>
                    <hr>
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block fw-semibold mb-1">Permisos asignados:</small>
                        <?php if ($rol === 'tecnico') { ?>
                            <small class="text-dark d-block"><i class="fa-solid fa-check text-success me-1"></i> Ver todos los tickets de la empresa</small>
                            <small class="text-dark d-block"><i class="fa-solid fa-check text-success me-1"></i> Modificar estados (Pendiente / En Proceso / Resuelto)</small>
                        <?php } else { ?>
                            <small class="text-dark d-block"><i class="fa-solid fa-check text-success me-1"></i> Registrar nuevas incidencias</small>
                            <small class="text-dark d-block"><i class="fa-solid fa-check text-success me-1"></i> Consultar seguimiento de solicitudes propias</small>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
