<?php
require "includes/session.php";
require "config/db.php";

$id_usuario = $_SESSION['id_usuario'];
$rol = $_SESSION['rol'];

if ($rol === 'tecnico') {
    $query = "SELECT t.*, u.nombre AS solicitante 
              FROM tickets t 
              INNER JOIN usuarios u ON t.id_usuario = u.id 
              ORDER BY t.id DESC";
    $stmt = $conn->prepare($query);
} else {
    $query = "SELECT t.*, u.nombre AS solicitante 
              FROM tickets t 
              INNER JOIN usuarios u ON t.id_usuario = u.id 
              WHERE t.id_usuario = ? 
              ORDER BY t.id DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_usuario);
}

$stmt->execute();
$resultado = $stmt->get_result();

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";
?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            
            <?php echo ($rol === 'tecnico') ? 'Gestión de Tickets' : 'Mis Tickets de Soporte'; ?>
        </h2>
        <a href="nuevoTicket.php" class="btn btn-primary shadow-sm">
            <i class="fa-solid fa-plus-circle me-1"></i> Registrar Nuevo Ticket
        </a>
    </div>

    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?php echo $_SESSION['tipo'] ?? 'info'; ?> alert-dismissible fade show shadow-sm mb-4">
            <i class="fa-solid fa-circle-info me-2"></i>
            <?php echo $_SESSION['mensaje']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php 
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
        }
        ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle datatable w-100">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <?php if ($rol === 'tecnico') { ?>
                                <th>Solicitante</th>
                            <?php } ?>
                            <th>Título / Asunto</th>
                            <th>Departamento</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th>Fecha Creación</th>
                            <th style="width: 140px;" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($resultado && $resultado->num_rows > 0) { ?>
                            <?php while ($ticket = $resultado->fetch_assoc()) { ?>
                                <?php
                                $trClass = "";
                                if ($ticket['prioridad'] === 'Alta') {
                                    $trClass = "tr-prioridad-alta";
                                } elseif ($ticket['estado'] === 'Pendiente') {
                                    $trClass = "tr-estado-pendiente";
                                } elseif ($ticket['estado'] === 'Resuelto') {
                                    $trClass = "tr-estado-resuelto";
                                }
                                ?>
                                <tr class="<?php echo $trClass; ?>">
                                    <td><strong>#<?php echo $ticket['id']; ?></strong></td>
                                    
                                    <?php if ($rol === 'tecnico') { ?>
                                        <td>
                                            <span class="fw-bold text-dark d-block"><?php echo htmlspecialchars($ticket['solicitante']); ?></span>
                                        </td>
                                    <?php } ?>

                                    <td>
                                        <span class="fw-semibold text-dark <?php echo ($ticket['prioridad'] === 'Alta') ? 'text-prioridad-alta' : ''; ?>">
                                            <?php echo htmlspecialchars($ticket['titulo']); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($ticket['departamento']); ?>
                                    </td>

                                    <td>
                                        <?php if ($ticket['prioridad'] === 'Alta') { ?>
                                            <span class="badge badge-prioridad-alta px-2 py-1">
                                                <i class="fa-solid fa-triangle-exclamation me-1"></i>Alta
                                            </span>
                                        <?php } elseif ($ticket['prioridad'] === 'Media') { ?>
                                            <span class="badge badge-prioridad-media px-2 py-1">
                                                <i class="fa-solid fa-circle-exclamation me-1"></i>Media
                                            </span>
                                        <?php } else { ?>
                                            <span class="badge badge-prioridad-baja px-2 py-1">
                                                <i class="fa-solid fa-circle-info me-1"></i>Baja
                                            </span>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?php if ($ticket['estado'] === 'Pendiente') { ?>
                                            <span class="badge badge-estado-pendiente px-2 py-1">
                                                <i class="fa-solid fa-hourglass-half me-1"></i>Pendiente
                                            </span>
                                        <?php } elseif ($ticket['estado'] === 'En Proceso') { ?>
                                            <span class="badge badge-estado-enproceso px-2 py-1">
                                                <i class="fa-solid fa-spinner fa-spin me-1"></i>En Proceso
                                            </span>
                                        <?php } else { ?>
                                            <span class="badge badge-estado-resuelto px-2 py-1">
                                                <i class="fa-solid fa-check-double me-1"></i>Resuelto
                                            </span>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <small class="text-muted fw-semibold">
                                            <?php echo date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])); ?>
                                        </small>
                                    </td>

                                    <td class="text-center">
                                        <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalDetalle<?php echo $ticket['id']; ?>" title="Ver Detalle">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <?php if ($rol === 'tecnico') { ?>
                                            <button type="button" class="btn btn-warning btn-sm text-dark ms-1" data-bs-toggle="modal" data-bs-target="#modalEstado<?php echo $ticket['id']; ?>" title="Cambiar Estado">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        <?php } ?>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalDetalle<?php echo $ticket['id']; ?>" tabindex="-1" aria-labelledby="labelDetalle<?php echo $ticket['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="labelDetalle<?php echo $ticket['id']; ?>">
                                                    <i class="fa-solid fa-ticket me-2"></i>Detalle de Ticket #<?php echo $ticket['id']; ?>
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <h4 class="fw-bold text-dark mb-3"><?php echo htmlspecialchars($ticket['titulo']); ?></h4>
                                                
                                                <div class="row bg-light p-3 rounded mb-3">
                                                    <div class="col-md-6 mb-2">
                                                        <strong>Solicitante:</strong> <?php echo htmlspecialchars($ticket['solicitante']); ?>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <strong>Departamento:</strong> <?php echo htmlspecialchars($ticket['departamento']); ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Prioridad:</strong> <span class="badge <?php echo ($ticket['prioridad']==='Alta')?'badge-prioridad-alta':(($ticket['prioridad']==='Media')?'badge-prioridad-media':'badge-prioridad-baja'); ?>"><?php echo $ticket['prioridad']; ?></span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Estado Actual:</strong> <span class="badge <?php echo ($ticket['estado']==='Resuelto')?'badge-estado-resuelto':(($ticket['estado']==='En Proceso')?'badge-estado-enproceso':'badge-estado-pendiente'); ?>"><?php echo $ticket['estado']; ?></span>
                                                    </div>
                                                </div>

                                                <h6 class="fw-bold text-secondary">Descripción de la Incidencia:</h6>
                                                <div class="p-3 border rounded bg-white text-dark mb-3">
                                                    <?php echo nl2br(htmlspecialchars($ticket['descripcion'])); ?>
                                                </div>

                                                <small class="text-muted d-block text-end">
                                                    Fecha de Registro: <?php echo date('d/m/Y h:i A', strtotime($ticket['fecha_creacion'])); ?>
                                                </small>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if ($rol === 'tecnico') { ?>
                                    <div class="modal fade" id="modalEstado<?php echo $ticket['id']; ?>" tabindex="-1" aria-labelledby="labelEstado<?php echo $ticket['id']; ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="controllers/cambiarEstadoTicket.php" method="POST">
                                                    <input type="hidden" name="id_ticket" value="<?php echo $ticket['id']; ?>">
                                                    <div class="modal-header bg-warning text-dark">
                                                        <h5 class="modal-title" id="labelEstado<?php echo $ticket['id']; ?>">
                                                            Cambiar Estado - Ticket <?php echo $ticket['id']; ?>
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4">
                                                        <p class="mb-3">Actualizar el estado del ticket: <strong><?php echo htmlspecialchars($ticket['titulo']); ?></strong></p>
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Seleccionar Nuevo Estado</label>
                                                            <select name="estado" class="form-select form-select-lg" required>
                                                                <option value="Pendiente" <?php if($ticket['estado'] === 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                                                                <option value="En Proceso" <?php if($ticket['estado'] === 'En Proceso') echo 'selected'; ?>>En Proceso</option>
                                                                <option value="Resuelto" <?php if($ticket['estado'] === 'Resuelto') echo 'selected'; ?>>Resuelto</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-warning fw-bold">
                                                             Actualizar Estado
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
