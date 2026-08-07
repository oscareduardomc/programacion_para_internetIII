<?php
require "includes/session.php";
require "config/db.php";

if ($_SESSION['rol'] == 'usuario') {
    $sql = "SELECT
                t.id,
                t.titulo,
                t.descripcion,
                t.departamento,
                t.prioridad,
                t.estado,
                t.fecha_creacion,
                u.nombre AS solicitante
            FROM tickets t
            INNER JOIN usuarios u
                ON u.id = t.id_usuario
            WHERE t.id_usuario = ?
            ORDER BY t.id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_SESSION['id']);
    $stmt->execute();
    $tickets = $stmt->get_result();
} else {
    $sql = "SELECT
                t.id,
                t.titulo,
                t.descripcion,
                t.departamento,
                t.prioridad,
                t.estado,
                t.fecha_creacion,
                u.nombre AS solicitante
            FROM tickets t
            INNER JOIN usuarios u
                ON u.id = t.id_usuario
            ORDER BY t.id DESC";
    $tickets = $conn->query($sql);
}

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";
?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-list"></i>
            Listado de Tickets
        </h2>

        <?php if ($_SESSION['rol'] == 'usuario') { ?>

        <a class="btn btn-primary" href="nuevoTicket.php">
            <i class="fa-solid fa-plus"></i>
            Nuevo Ticket
        </a>

        <?php } ?>
    </div>

    <?php
    if (isset($_SESSION['mensaje'])){
    ?>
    <div class="alert alert-<?php echo $_SESSION['tipo']; ?> alert-dismissible fade show">
        <?php echo $_SESSION['mensaje']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
    }
    ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Departamento</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <?php if ($_SESSION['rol'] == 'tecnico') { ?>
                            <th>Cambiar Estado</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($tickets->num_rows > 0) { ?>
                            <?php while ($ticket = $tickets->fetch_assoc()) { ?>

                                <?php
                                $fila_clase = '';
                                if ($ticket['prioridad'] == 'Alta') {
                                    $fila_clase = 'prioridad-alta';
                                } elseif ($ticket['prioridad'] == 'Media') {
                                    $fila_clase = 'prioridad-media';
                                }

                                $badge_estado = '';
                                if ($ticket['estado'] == 'Pendiente') {
                                    $badge_estado = 'badge-pendiente';
                                } elseif ($ticket['estado'] == 'En Proceso') {
                                    $badge_estado = 'badge-proceso';
                                } else {
                                    $badge_estado = 'badge-resuelto';
                                }
                                ?>

                                <tr class="<?php echo $fila_clase; ?>">
                                    <td><?php echo $ticket['id']; ?></td>
                                    <td><?php echo htmlspecialchars($ticket['titulo']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['descripcion']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['departamento']); ?></td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <?php echo $ticket['prioridad']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo $badge_estado; ?>">
                                            <?php echo $ticket['estado']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])); ?></td>
                                    <?php if ($_SESSION['rol'] == 'tecnico') { ?>
                                    <td>
                                        <form action="controllers/cambiarEstado.php" method="POST" class="d-flex gap-2">
                                            <input type="hidden" name="id" value="<?php echo $ticket['id']; ?>">
                                            <select name="estado" class="form-select form-select-sm">
                                                <option value="Pendiente" <?php echo $ticket['estado'] == 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                                <option value="En Proceso" <?php echo $ticket['estado'] == 'En Proceso' ? 'selected' : ''; ?>>En Proceso</option>
                                                <option value="Resuelto" <?php echo $ticket['estado'] == 'Resuelto' ? 'selected' : ''; ?>>Resuelto</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <?php } ?>
                                </tr>

                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="<?php echo $_SESSION['rol'] == 'tecnico' ? 8 : 7; ?>" class="text-center">
                                    No hay tickets registrados.
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php
include "includes/footer.php";
?>
