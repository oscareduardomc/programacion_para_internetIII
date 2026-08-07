<?php
require "includes/session.php";
require "config/db.php";

$idUsuario = (int) $_SESSION['id'];
$rol = $_SESSION['rol'];

if ($rol === 'usuario') {
    $query = "SELECT t.id, t.titulo, t.descripcion, t.prioridad, t.estado, t.fecha_creacion, u.nombre AS creador
              FROM tickets t
              INNER JOIN usuarios u ON u.id = t.id_usuario
              WHERE t.id_usuario = ?
              ORDER BY t.fecha_creacion DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idUsuario);
} else {
    $query = "SELECT t.id, t.titulo, t.descripcion, t.prioridad, t.estado, t.fecha_creacion, u.nombre AS creador
              FROM tickets t
              INNER JOIN usuarios u ON u.id = t.id_usuario
              ORDER BY t.fecha_creacion DESC";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$tickets = $stmt->get_result();

include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";
?>

<div class="content">
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div class="alert alert-<?php echo htmlspecialchars($_SESSION['tipo'] ?? 'info'); ?> alert-dismissible fade show">
            <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
        ?>
    <?php endif; ?>

    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0">
                <i class="fa-solid fa-table-list me-2"></i>
                <?php echo $rol === 'tecnico' ? 'Todos los Tickets' : 'Mis Tickets'; ?>
            </h5>
            <?php if ($rol === 'usuario'): ?>
                <a href="nuevoTicket.php" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-plus me-1"></i>Nuevo Ticket
                </a>
            <?php endif; ?>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Prioridad</th>
                        <th>Estado</th>
                        <th>Fecha de creación</th>
                        <?php if ($rol === 'tecnico'): ?>
                            <th>Creado por</th>
                            <th>Gestión</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($tickets->num_rows > 0): ?>
                        <?php while ($ticket = $tickets->fetch_assoc()): ?>
                            <?php
                            $claseFila = $ticket['prioridad'] === 'Alta' ? 'prioridad-alta' : '';

                            $clasePrioridad = match ($ticket['prioridad']) {
                                'Alta' => 'badge-prioridad-alta',
                                'Media' => 'badge-prioridad-media',
                                default => 'badge-prioridad-baja',
                            };

                            $claseEstado = match ($ticket['estado']) {
                                'Resuelto' => 'badge-resuelto',
                                'En Proceso' => 'badge-proceso',
                                default => 'badge-pendiente',
                            };
                            ?>
                            <tr class="<?php echo $claseFila; ?>">
                                <td><?php echo (int) $ticket['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($ticket['titulo']); ?></strong></td>
                                <td>
                                    <span class="descripcion-corta" title="<?php echo htmlspecialchars($ticket['descripcion']); ?>">
                                        <?php echo htmlspecialchars($ticket['descripcion']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?php echo $clasePrioridad; ?>">
                                        <?php echo htmlspecialchars($ticket['prioridad']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?php echo $claseEstado; ?>">
                                        <?php echo htmlspecialchars($ticket['estado']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])); ?></td>
                                <?php if ($rol === 'tecnico'): ?>
                                    <td><?php echo htmlspecialchars($ticket['creador']); ?></td>
                                    <td>
                                        <form action="controllers/cambiarEstado.php" method="POST" class="d-flex gap-2">
                                            <input type="hidden" name="id_ticket" value="<?php echo (int) $ticket['id']; ?>">
                                            <select name="estado" class="form-select form-select-sm">
                                                <option value="Pendiente" <?php echo $ticket['estado'] === 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                                <option value="En Proceso" <?php echo $ticket['estado'] === 'En Proceso' ? 'selected' : ''; ?>>En Proceso</option>
                                                <option value="Resuelto" <?php echo $ticket['estado'] === 'Resuelto' ? 'selected' : ''; ?>>Resuelto</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="<?php echo $rol === 'tecnico' ? '8' : '6'; ?>" class="text-center text-muted py-4">
                                No hay tickets registrados.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$stmt->close();
$conn->close();
include "includes/footer.php";
?>
