<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
require "includes/session.php";
require "config/db.php";

// Segun el rol, se traen todos los tickets o solo los del usuario
if ($_SESSION['rol'] === 'tecnico') {
    $sql = "SELECT t.id, t.titulo, t.descripcion, t.prioridad, t.estado, t.fecha_creacion, u.nombre
            FROM tickets t
            INNER JOIN usuarios u ON t.id_usuario = u.id
            ORDER BY t.fecha_creacion DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
} else {
    $sql = "SELECT id, titulo, descripcion, prioridad, estado, fecha_creacion
            FROM tickets
            WHERE id_usuario = :id_usuario
            ORDER BY fecha_creacion DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_usuario', $_SESSION['id']);
    $stmt->execute();
}

$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Tickets</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        body { background-color: #f4f6f9; }
        .fila-alta { background-color: #f8d7da !important; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-primary px-3">
    <span class="navbar-brand mb-0 h1"><i class="fa-solid fa-headset"></i> Sistema de Tickets</span>
    <div class="text-white">
        <?= htmlspecialchars($_SESSION['nombre']) ?>
        (<?= $_SESSION['rol'] === 'tecnico' ? 'Tecnico' : 'Usuario' ?>)
        <a href="logout.php" class="btn btn-outline-light btn-sm ms-3">
            <i class="fa-solid fa-right-from-bracket"></i> Salir
        </a>
    </div>
</nav>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><?= $_SESSION['rol'] === 'tecnico' ? 'Todos los Tickets' : 'Mis Tickets' ?></h4>

        <?php if ($_SESSION['rol'] === 'usuario'): ?>
            <a href="registrar_ticket.php" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Nuevo Ticket
            </a>
        <?php endif; ?>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Titulo</th>
                        <th>Descripcion</th>
                        <?php if ($_SESSION['rol'] === 'tecnico'): ?>
                            <th>Solicitante</th>
                        <?php endif; ?>
                        <th>Prioridad</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <?php if ($_SESSION['rol'] === 'tecnico'): ?>
                            <th>Accion</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($tickets) === 0): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">No hay tickets registrados.</td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($tickets as $ticket): ?>
                        <?php $claseFila = ($ticket['prioridad'] === 'Alta') ? 'fila-alta' : ''; ?>
                        <tr class="<?= $claseFila ?>">
                            <td><?= $ticket['id'] ?></td>
                            <td><?= htmlspecialchars($ticket['titulo']) ?></td>
                            <td><?= htmlspecialchars($ticket['descripcion']) ?></td>
                            <?php if ($_SESSION['rol'] === 'tecnico'): ?>
                                <td><?= htmlspecialchars($ticket['nombre']) ?></td>
                            <?php endif; ?>
                            <td>
                                <?php if ($ticket['prioridad'] === 'Alta'): ?>
                                    <span class="badge bg-danger">Alta</span>
                                <?php elseif ($ticket['prioridad'] === 'Media'): ?>
                                    <span class="badge bg-secondary">Media</span>
                                <?php else: ?>
                                    <span class="badge bg-light text-dark">Baja</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($ticket['estado'] === 'Pendiente'): ?>
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                <?php elseif ($ticket['estado'] === 'En Proceso'): ?>
                                    <span class="badge bg-info text-dark">En Proceso</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Resuelto</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $ticket['fecha_creacion'] ?></td>

                            <?php if ($_SESSION['rol'] === 'tecnico'): ?>
                                <td>
                                    <form action="controllers/cambiar_estado.php" method="POST" class="d-flex gap-1">
                                        <input type="hidden" name="id" value="<?= $ticket['id'] ?>">
                                        <select name="estado" class="form-select form-select-sm">
                                            <option value="Pendiente" <?= $ticket['estado'] === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                            <option value="En Proceso" <?= $ticket['estado'] === 'En Proceso' ? 'selected' : '' ?>>En Proceso</option>
                                            <option value="Resuelto" <?= $ticket['estado'] === 'Resuelto' ? 'selected' : '' ?>>Resuelto</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>