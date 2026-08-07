<?php
require "includes/session.php";
require "config/db.php";

$rol = $_SESSION['usuario_rol'];
$id_usuario = $_SESSION['usuario_id'];

if ($rol === 'tecnico') {
    $query = "SELECT
                t.id,
                t.titulo,
                t.descripcion,
                t.prioridad,
                t.estado,
                t.fecha_creacion,
                u.nombre AS usuario_nombre
              FROM tickets t
              INNER JOIN usuarios u ON t.id_usuario = u.id
              ORDER BY t.id DESC";
    $resultado = $conn->query($query);
} else {
    $query = "SELECT
                id,
                titulo,
                descripcion,
                prioridad,
                estado,
                fecha_creacion
              FROM tickets
              WHERE id_usuario = ?
              ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
}

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";
?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>

            <?php echo $rol === 'tecnico' ? 'Todos los Tickets' : 'Mis Tickets'; ?>
        </h2>

        <?php if ($rol === 'usuario') { ?>
            <a class="btn btn-primary" href="crearTicket.php">
                <i class="fa-solid fa-plus"></i>
                Nuevo Ticket
            </a>
        <?php } ?>
    </div>

    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?php echo htmlspecialchars($_SESSION['tipo']); ?>">
            <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
        </div>
        <?php
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
        ?>
    <?php } ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <?php if ($rol === 'tecnico') { ?>
                                <th>Usuario</th>
                            <?php } ?>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <?php if ($rol === 'tecnico') { ?>
                                <th>Acciones</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($ticket = $resultado->fetch_assoc()) { ?>
                            <tr class="<?php echo $ticket['prioridad'] === 'Alta' ? 'table-danger' : ''; ?>">
                                <td><?php echo $ticket['id']; ?></td>

                                <?php if ($rol === 'tecnico') { ?>
                                    <td><?php echo htmlspecialchars($ticket['usuario_nombre']); ?></td>
                                <?php } ?>

                                <td><?php echo htmlspecialchars($ticket['titulo']); ?></td>
                                <td><?php echo htmlspecialchars($ticket['descripcion']); ?></td>
                                <td>
                                    <?php if ($ticket['prioridad'] === 'Alta') { ?>
                                        <span class="badge bg-danger">Alta</span>
                                    <?php } else { ?>
                                        <?php echo htmlspecialchars($ticket['prioridad']); ?>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($ticket['estado'] === 'Pendiente') { ?>

                                        <span class="badge bg-warning text-dark">Pendiente</span>

                                    <?php } elseif ($ticket['estado'] === 'Resuelto') { ?>
                                        <span class="badge bg-success">Resuelto</span>
                                    <?php } else { ?>
                                        <span class="badge bg-primary">En Proceso</span>
                                    <?php } ?>
                                </td>
                                <td><?php echo htmlspecialchars($ticket['fecha_creacion']); ?></td>

                                <?php if ($rol === 'tecnico') { ?>
                                    <td>
                                        <form action="controllers/actualizarEstado.php" method="POST">

                                            <input type="hidden" name="id" value="<?php echo $ticket['id']; ?>">
                                            <select name="estado" class="form-select form-select-sm mb-2">
                                                <option value="Pendiente" <?php echo $ticket['estado'] === 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                                <option value="En Proceso" <?php echo $ticket['estado'] === 'En Proceso' ? 'selected' : ''; ?>>En Proceso</option>
                                                <option value="Resuelto" <?php echo $ticket['estado'] === 'Resuelto' ? 'selected' : ''; ?>>Resuelto</option>
                                            </select>
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fa-solid fa-pen"></i>
                                                Actualizar
                                            </button>
                                        </form>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>