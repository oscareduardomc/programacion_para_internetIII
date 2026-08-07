<?php
require "includes/session.php";
require "config/db.php";

$id  = $_SESSION['id'];
$rol = $_SESSION['rol'];

if ($rol === 'usuario') {
    $stmt = $conn->prepare("
        SELECT t.*, u.nombre as nombre_usuario
        FROM tickets t
        INNER JOIN usuarios u ON u.id = t.id_usuario
        WHERE t.id_usuario = ?
        ORDER BY t.fecha_creacion DESC
    ");
    $stmt->bind_param("i", $id);
} else {
    $stmt = $conn->prepare("
        SELECT t.*, u.nombre as nombre_usuario
        FROM tickets t
        INNER JOIN usuarios u ON u.id = t.id_usuario
        ORDER BY t.fecha_creacion DESC
    ");
}

$stmt->execute();
$tickets = $stmt->get_result();

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";
?>

<div class="content">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
           
            <?php echo $rol === 'usuario' ? 'Mis Tickets' : 'Todos los Tickets'; ?>
        </h2>
        <?php if ($rol === 'usuario') { ?>
            <a href="nuevoTicket.php" class="btn btn-primary">
                Nuevo Ticket
            </a>
        <?php } ?>
    </div>

    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?php echo $_SESSION['tipo']; ?>">
            <?php echo $_SESSION['mensaje']; ?>
        </div>
    <?php
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
    } ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <?php if ($rol === 'tecnico') { ?><th>Usuario</th><?php } ?>
                            <th>Título</th>
                            <th>Departamento</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <?php if ($rol === 'tecnico') { ?><th>Acciones</th><?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($ticket = $tickets->fetch_assoc()) { ?>
                            <tr class="<?php echo $ticket['prioridad'] === 'Alta' ? 'prioridad-alta' : ($ticket['prioridad'] === 'Media' ? 'prioridad-media' : ''); ?>">
                                <td><?php echo $ticket['id']; ?></td>
                                <?php if ($rol === 'tecnico') { ?>
                                    <td><?php echo $ticket['nombre_usuario']; ?></td>
                                <?php } ?>
                                <td><?php echo $ticket['titulo']; ?></td>
                                <td><?php echo $ticket['departamento']; ?></td>
                                <td>
                                    <?php
                                    $badgePrioridad = [
                                        'Alta'  => 'danger',
                                        'Media' => 'warning',
                                        'Baja'  => 'secondary'
                                    ];
                                    $b = $badgePrioridad[$ticket['prioridad']] ?? 'secondary';
                                    echo "<span class=\"badge bg-$b\">{$ticket['prioridad']}</span>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $badgeEstado = [
                                        'Pendiente'  => 'warning',
                                        'En Proceso' => 'info',
                                        'Resuelto'   => 'success'
                                    ];
                                    $b = $badgeEstado[$ticket['estado']] ?? 'secondary';
                                    echo "<span class=\"badge bg-$b\">{$ticket['estado']}</span>";
                                    ?>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])); ?></td>
                                <?php if ($rol === 'tecnico') { ?>
                                    <td>
                                        <a href="verTicket.php?id=<?php echo $ticket['id']; ?>"
                                           class="btn btn-info btn-sm text-white">
                                             cambiar estado
                                        </a>
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