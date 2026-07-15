<?php
require_once 'controladores/EmpleadoController.php';

if (isset($_GET['action']) && $_GET['action'] == 'eliminar' && isset($_GET['id'])) {
    EmpleadoController::eliminar($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Control de Empleados</title>
    <!--BOOTSRAp CSS CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- BOOTSRAP Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
<div class="d-flex">

<?php
// Cargar Sidebar
include "vistas/modulos/sidebar.php";

//Lógica enrutamiento de vistas
$action = isset($_GET['action']) ? $_GET['action'] : 'inicio';

switch ($action) {
    case 'inicio':
        include "vistas/inicio.php";
        break;
    case 'crear':
        include "vistas/crear.php";
        break;
    case 'editar':
        include "vistas/editar.php";
        break;
    default:
        include "vistas/inicio.php";
        break;
}

// Cargar Footer
include "vistas/modulos/footer.php";
?>
</div>
</body>
</html>

