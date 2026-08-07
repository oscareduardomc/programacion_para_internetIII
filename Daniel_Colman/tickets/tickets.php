<?php
require "includes/session.php";
require "config/db.php";

$rol       = $_SESSION['rol'];
$id_actual = $_SESSION['id'];

// Si es usuario, solo ve sus tickets
if ($rol === 'usuario') {
    $query = "
        SELECT t.*, u.nombre
        FROM tickets t
        INNER JOIN usuarios u ON t.id_usuario = u.id
        WHERE t.id_usuario = ?
        ORDER BY t.fecha_creacion DESC
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_actual);
} else {
    // Técnico ve todos
    $query = "
        SELECT t.*, u.nombre
        FROM tickets t
        INNER JOIN usuarios u ON t.id_usuario = u.id
        ORDER BY t.fecha_creacion DESC
    ";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$resultado = $stmt->get_result();

require "includes/header.php";
require "includes/navbar.php";
require "includes/sidebar.php";
?>

<div class="content container mt-4">
    <h3>Listado de Tickets</h3>

    <?php
    if (isset($_SESSION['mensaje'])) {
        $tipo = $_SESSION['tipo'] ?? 'info';
        echo '<div class="alert alert-'.$tipo.'">'.$_SESSION['mensaje'].'</div>';
        unset($_SESSION['mensaje'], $_SESSION['tipo']);
    }
    ?>

    <?php if ($rol === 'usuario'): ?>
        <a href="nuevoTicket.php" class="btn btn-success mb-3">
            Nuevo Ticket
        </a>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Título</th>
                <th>Departamento</th>
                <th>Prioridad</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Usuario</th>
                <?php if ($rol === 'tecnico'): ?>
                    <th>Acciones</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($ticket = $resultado->fetch_assoc()): ?>
                <?php
                // Clases CSS según prioridad/estado
                $claseFila = '';
                if ($ticket['prioridad'] === 'Alta') {
                    $claseFila = 'table-danger';
                }

                $badgeEstado = '';
                if ($ticket['estado'] === 'Pendiente') {
                    $badgeEstado = '<span class="badge bg-warning text-dark">Pendiente</span>';
                } elseif ($ticket['estado'] === 'En Proceso') {
                    $badgeEstado = '<span class="badge bg-info text-dark">En Proceso</span>';
                } else {
                    $badgeEstado = '<span class="badge bg-success">Resuelto</span>';
                }
                ?>
                <tr class="<?php echo $claseFila; ?>">
                    <td><?php echo htmlspecialchars($ticket['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($ticket['departamento']); ?></td>
                    <td><?php echo $ticket['prioridad']; ?></td>
                    <td><?php echo $badgeEstado; ?></td>
                    <td><?php echo $ticket['fecha_creacion']; ?></td>
                    <td><?php echo htmlspecialchars($ticket['nombre']); ?></td>
                    <?php if ($rol === 'tecnico'): ?>
                        <td>
                            <form action="controllers/cambiarEstado.php" method="POST" class="d-flex gap-1">
                                <input type="hidden" name="id_ticket" value="<?php echo $ticket['id']; ?>">
                                <select name="estado" class="form-select form-select-sm">
                                    <option value="Pendiente"    <?php if ($ticket['estado']==='Pendiente') echo 'selected'; ?>>Pendiente</option>
                                    <option value="En Proceso"   <?php if ($ticket['estado']==='En Proceso') echo 'selected'; ?>>En Proceso</option>
                                    <option value="Resuelto"     <?php if ($ticket['estado']==='Resuelto') echo 'selected'; ?>>Resuelto</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Cambiar
                                </button>
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
require "includes/footer.php";
$stmt->close();
$conn->close();
?>
