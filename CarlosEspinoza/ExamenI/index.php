<?php
require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/controladores/respuestosController.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'guardar':
        respuestosController::guardar($_POST['codigo_pieza'], $_POST['nombre'], $_POST['id_categoria'], $_POST['stock'], $_POST['precio']);
        break;
    case 'actualizar':
        respuestosController::actualizar($_POST['id'], $_POST['codigo_pieza'], $_POST['nombre'], $_POST['id_categoria'], $_POST['stock'], $_POST['precio']);
        break;
    case 'cambiar_estado':
        respuestosController::cambiarEstado($_GET['id'], $_GET['estado']);
        break;
    case 'eliminar':
        respuestosController::eliminar($_GET['id']);
        break;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller Repuestos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <div class="d-flex">
        <?php include 'vistas/modulos/sidebar.php'; ?>
        <div class="container-fluid p-4">
            <?php
            switch ($action) {
                case 'crear':
                    include 'vistas/crear.php';
                    break;
                case 'editar':
                    include 'vistas/editar.php';
                    break;
                case 'inactivos':
                    include 'vistas/inactivos.php';
                    break;
                default:
                    include 'vistas/inicio.php';
                    break;
            }
            ?>
            <?php include 'vistas/modulos/footer.php'; ?>
        </div>
    </div>
</body>

</html>
