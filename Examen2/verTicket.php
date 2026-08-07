<?php
require "includes/session.php";
require "config/db.php";

// Solo el técnico puede gestionar tickets
if ($_SESSION['rol'] !== 'tecnico') {
    header("Location: dashboard.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: tickets.php");
    exit;
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("
    SELECT t.*, u.nombre as nombre_usuario, u.email
    FROM tickets t
    INNER JOIN usuarios u ON u.id = t.id_usuario
    WHERE t.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    header("Location: tickets.php");
    exit;
}

$ticket = $resultado->fetch_assoc();

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";
?>

<div class="content">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-pen-to-square"></i>
            Gestionar Ticket #<?php echo $ticket['id']; ?>
        </h2>
        <a href="tickets.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Regresar
        </a>
    </div>

    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?php echo $_SESSION['tipo']; ?>">
            <?php echo $_SESSION['mensaje']; ?>
        </div>
    <?php
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
    } ?>

    <div class="row">

        <!-- Detalle del ticket -->
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Detalle del Ticket</strong>
                </div>
                <div class="card-body">

                    <p><strong>Título:</strong> <?php echo $ticket['titulo']; ?></p>
                    <p><strong>Usuario:</strong> <?php echo $ticket['nombre_usuario']; ?> (<?php echo $ticket['email']; ?>)</p>
                    <p><strong>Departamento:</strong> <?php echo $ticket['departamento']; ?></p>
                    <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($ticket['fecha_creacion'])); ?></p>

                    <p>
                        <strong>Prioridad:</strong>
                        <?php
                        $badgePrioridad = [
                            'Alta'  => 'danger',
                            'Media' => 'warning',
                            'Baja'  => 'secondary'
                        ];
                        $b = $badgePrioridad[$ticket['prioridad']];
                        echo "<span class=\"badge bg-$b\">{$ticket['prioridad']}</span>";
                        ?>
                    </p>

                    <p>
                        <strong>Estado actual:</strong>
                        <?php
                        $badgeEstado = [
                            'Pendiente'  => 'warning',
                            'En Proceso' => 'info',
                            'Resuelto'   => 'success'
                        ];
                        $b = $badgeEstado[$ticket['estado']];
                        echo "<span class=\"badge bg-$b\">{$ticket['estado']}</span>";
                        ?>
                    </p>

                    <hr>

                    <p><strong>Descripción:</strong></p>
                    <p><?php echo nl2br($ticket['descripcion']); ?></p>

                </div>
            </div>
        </div>

        <!-- Cambiar estado -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <strong>Cambiar Estado</strong>
                </div>
                <div class="card-body">

                    <form action="controllers/cambiarEstado.php" method="POST">

                        <input type="hidden" name="id" value="<?php echo $ticket['id']; ?>">

                        <div class="mb-3">
                            <label class="form-label">Nuevo Estado</label>
                            <select name="estado" class="form-control">
                                <option value="Pendiente"  <?php if ($ticket['estado'] == 'Pendiente')  echo 'selected'; ?>>Pendiente</option>
                                <option value="En Proceso" <?php if ($ticket['estado'] == 'En Proceso') echo 'selected'; ?>>En Proceso</option>
                                <option value="Resuelto"   <?php if ($ticket['estado'] == 'Resuelto')   echo 'selected'; ?>>Resuelto</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-floppy-disk"></i>
                                Actualizar Estado
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>

</div>

<?php include "includes/footer.php"; ?>