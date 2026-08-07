<?php
session_start();
require "db.php"; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$rol = $_SESSION['rol'];


// Guardar Ticket (Solo Usuario)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_crear_ticket'])) {
    $titulo = $_POST['titulo'];
    $departamento = $_POST['departamento'];
    $prioridad = $_POST['prioridad'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO tickets (id_usuario, titulo, departamento, prioridad, descripcion) 
            VALUES ('$user_id', '$titulo', '$departamento', '$prioridad', '$descripcion')";
    $conn->query($sql);
    header("Location: dashboard.php");
    exit();
}

// Cambiar Estado (Solo Técnico)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_cambiar_estado'])) {
    $id = $_POST['id'];
    $estado = $_POST['estado'];

    $sql = "UPDATE tickets SET estado = '$estado' WHERE id = '$id'";
    $conn->query($sql);
    header("Location: dashboard.php");
    exit();
}

//Indicadores

// Total
$sql = ($rol == 'usuario') ? "SELECT COUNT(*) total FROM tickets WHERE id_usuario = '$user_id'" : "SELECT COUNT(*) total FROM tickets";
$total_tickets = $conn->query($sql)->fetch_assoc()['total'];

// Pendientes
$sql = ($rol == 'usuario') ? "SELECT COUNT(*) total FROM tickets WHERE id_usuario = '$user_id' AND estado = 'Pendiente'" : "SELECT COUNT(*) total FROM tickets WHERE estado = 'Pendiente'";
$tickets_pendientes = $conn->query($sql)->fetch_assoc()['total'];

// En Proceso
$sql = ($rol == 'usuario') ? "SELECT COUNT(*) total FROM tickets WHERE id_usuario = '$user_id' AND estado = 'En Proceso'" : "SELECT COUNT(*) total FROM tickets WHERE estado = 'En Proceso'";
$tickets_proceso = $conn->query($sql)->fetch_assoc()['total'];

// Resueltos
$sql = ($rol == 'usuario') ? "SELECT COUNT(*) total FROM tickets WHERE id_usuario = '$user_id' AND estado = 'Resuelto'" : "SELECT COUNT(*) total FROM tickets WHERE estado = 'Resuelto'";
$tickets_resueltos = $conn->query($sql)->fetch_assoc()['total'];


// TABLA 1: Listado de tickets
if ($rol == 'usuario') {
    $sql_tickets = "SELECT * FROM tickets WHERE id_usuario = '$user_id' ORDER BY id DESC";
} else {
    $sql_tickets = "SELECT t.*, u.nombre AS usuario_nombre 
                    FROM tickets t 
                    INNER JOIN usuarios u ON t.id_usuario = u.id 
                    ORDER BY t.id DESC";
}
$tabla_tickets = $conn->query($sql_tickets);

// TABLA 2: Resumen por departamento
$sql_departamentos = "SELECT departamento, COUNT(*) AS total_dept,
                       SUM(CASE WHEN estado = 'Pendiente' THEN 1 ELSE 0 END) AS pendientes
                       FROM tickets 
                       GROUP BY departamento";
$tabla_departamentos = $conn->query($sql_departamentos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Tickets</title>
  

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .card-dashboard { border: none; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,.08); }
        .icono { font-size: 35px; opacity: .25; }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">



    <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white rounded shadow-sm">
        <h4 class="m-0 text-primary"></i> Sistema de Tickets</h4>
        <div>
            <span class="me-3">Hola, <strong><?php echo $_SESSION['nombre']; ?></strong> (<?php echo ucfirst($_SESSION['rol']); ?>)</span>
            <a href="logout.php" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-right-from-bracket"></i> Salir</a>
        </div>
    </div>


   // <!--INDICADORES -->
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card card-dashboard">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div><h6 class="text-muted">Total Tickets</h6><h3><?php echo $total_tickets; ?></h3></div>
                    <i class="fa-solid fa-ticket icono text-primary"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card card-dashboard">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div><h6 class="text-muted">Pendientes</h6><h3><?php echo $tickets_pendientes; ?></h3></div>
                    <i class="fa-solid fa-clock icono text-warning"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card card-dashboard">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div><h6 class="text-muted">En Proceso</h6><h3><?php echo $tickets_proceso; ?></h3></div>
                    <i class="fa-solid fa-spinner icono text-info"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card card-dashboard">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div><h6 class="text-muted">Resueltos</h6><h3><?php echo $tickets_resueltos; ?></h3></div>
                    <i class="fa-solid fa-circle-check icono text-success"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">

            <!-- FORMULARIO PARA USUARIO -->
            <?php if ($rol == 'usuario'): ?>
                <div class="card card-dashboard mb-4">
                    <div class="card-header bg-white">
                        <strong><i class="fa-solid fa-plus text-primary"></i> Registrar Nuevo Ticket</strong>
                    </div>
                    <div class="card-body">
                        <form action="dashboard.php" method="POST" onsubmit="return validarFormulario();">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Título *</label>
                                    <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Ej. Impresora dañada">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Departamento *</label>
                                    <input type="text" id="departamento" name="departamento" class="form-control" placeholder="Ej. Contabilidad">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Prioridad *</label>
                                    <select id="prioridad" name="prioridad" class="form-select">
                                        <option value="">-- Seleccione --</option>
                                        <option value="Baja">Baja</option>
                                        <option value="Media">Media</option>
                                        <option value="Alta">Alta</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Descripción *</label>
                                    <textarea id="descripcion" name="descripcion" class="form-control" rows="1" placeholder="Detalle el problema"></textarea>
                                </div>
                            </div>
                            <button type="submit" name="btn_crear_ticket" class="btn btn-primary">
                                <i class="fa-solid fa-paper-plane"></i> Guardar Ticket
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <!-- TABLA 1: LISTADO GENERAL -->
            <div class="card card-dashboard mb-4">
                <div class="card-header bg-white">
                    <strong><i class="fa-solid fa-list text-primary"></i> Tabla 1: Listado de Tickets</strong>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <?php if ($rol == 'tecnico'): ?><th>Usuario</th><?php endif; ?>
                                    <th>Título</th>
                                    <th>Departamento</th>
                                    <th>Prioridad</th>
                                    <th>Estado</th>
                                    <?php if ($rol == 'tecnico'): ?><th>Acción</th><?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($tabla_tickets && $tabla_tickets->num_rows > 0) { ?>
                                    <?php while ($row = $tabla_tickets->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <?php if ($rol == 'tecnico'): ?>
                                                <td><strong><?php echo $row['usuario_nombre']; ?></strong></td>
                                            <?php endif; ?>
                                            <td><?php echo $row['titulo']; ?></td>
                                            <td><?php echo $row['departamento']; ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo ($row['prioridad']=='Alta') ? 'danger' : (($row['prioridad']=='Media') ? 'warning text-dark' : 'secondary'); ?>">
                                                    <?php echo $row['prioridad']; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo ($row['estado']=='Pendiente') ? 'warning text-dark' : (($row['estado']=='En Proceso') ? 'info text-dark' : 'success'); ?>">
                                                    <?php echo $row['estado']; ?>
                                                </span>
                                            </td>
                                            <?php if ($rol == 'tecnico'): ?>
                                                <td>
                                                    <form action="dashboard.php" method="POST" class="d-flex gap-1">
                                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                        <select name="estado" class="form-select form-select-sm">
                                                            <option value="Pendiente" <?php echo ($row['estado'] == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                                            <option value="En Proceso" <?php echo ($row['estado'] == 'En Proceso') ? 'selected' : ''; ?>>En Proceso</option>
                                                            <option value="Resuelto" <?php echo ($row['estado'] == 'Resuelto') ? 'selected' : ''; ?>>Resuelto</option>
                                                        </select>
                                                        <button type="submit" name="btn_cambiar_estado" class="btn btn-sm btn-primary">
                                                            <i class="fa-solid fa-check"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr><td colspan="7" class="text-center">No hay tickets registrados.</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TABLA 2: RESUMEN POR DEPARTAMENTO -->
            <div class="card card-dashboard mb-4">
                <div class="card-header bg-white">
                    <strong><i class="fa-solid fa-building text-primary"></i> Tabla 2: Resumen por Departamento</strong>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Departamento</th>
                                    <th>Total Registrados</th>
                                    <th>Pendientes por Resolver</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($tabla_departamentos && $tabla_departamentos->num_rows > 0) { ?>
                                    <?php while ($dept = $tabla_departamentos->fetch_assoc()) { ?>
                                        <tr>
                                            <td><strong><?php echo $dept['departamento']; ?></strong></td>
                                            <td><?php echo $dept['total_dept']; ?></td>
                                            <td><span class="badge bg-warning text-dark"><?php echo $dept['pendientes']; ?></span></td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr><td colspan="3" class="text-center">Sin datos.</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- INFORMACIÓN USUARIO -->
        <div class="col-lg-4">
            <div class="card card-dashboard">
                <div class="card-header bg-white">
                    <strong><i class="fa-solid fa-user-gear text-primary"></i> Datos del Usuario</strong>
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> <?php echo $_SESSION['nombre']; ?></p>
                    <p><strong>Rol asignado:</strong> <span class="badge bg-primary"><?php echo ucfirst($_SESSION['rol']); ?></span></p>
                    <hr>
                    <div class="alert alert-info border-0 mb-0">
                        <i class="fa-solid fa-circle-info"></i>
                        <?php if ($rol == 'usuario'): ?>
                            Puedes crear tickets para reportar fallas e incidencias.
                        <?php else: ?>
                            Como técnico, puedes actualizar el estado de cada ticket en la lista.
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function validarFormulario() {
    let titulo = document.getElementById('titulo').value.trim();
    let departamento = document.getElementById('departamento').value.trim();
    let prioridad = document.getElementById('prioridad').value;
    let descripcion = document.getElementById('descripcion').value.trim();

    if (titulo === '' || departamento === '' || prioridad === '' || descripcion === '') {
        alert('Por favor complete todos los campos obligatorios.');
        return false;
    }
    return true;
}
</script>
</body>
</html>