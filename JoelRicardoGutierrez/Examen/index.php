<?php
require_once 'controladores/ClienteController.php';
require_once 'controladores/ProyectoController.php';

$action = $_GET['action'] ?? 'inicio';

if ($action === 'soft_delete' && isset($_GET['id'])) {
    ProyectoController::softDelete($_GET['id']);
}

if ($action === 'hard_delete' && isset($_GET['id'])) {
    ProyectoController::hardDelete($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de proyectos tecnológicos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
<div class="d-flex">
<?php include 'vistas/modulos/sidebar.php'; ?>

<?php
switch ($action) {
    case 'crear':
        include 'vistas/crear.php';
        break;
    case 'editar':
        include 'vistas/editar.php';
        break;
    case 'admin':
        include 'vistas/admin.php';
        break;
    default:
        include 'vistas/inicio.php';
        break;
}
?>

<?php include 'vistas/modulos/footer.php'; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
