<?php
require_once('./controladores/ProyectosController.php');

$action = isset($_GET['action']) ? $_GET['action'] : 'inicio';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Proyectos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">

    <?php include "./vistas/modulos/sidebar.php"; ?>

    <?php
    switch ($action) {

        case 'crear':
            require_once('./vistas/crear.php');
            break;

        case 'guardar':
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                ProyectosController::guardar(
                    $_POST['titulo'],
                    $_POST['descripcion'],
                    $_POST['id_cliente'],
                    $_POST['presupuesto'],
                    $_POST['fecha_entrega']
                );
            }
            break;

        case 'editar':
            include "./vistas/editar.php";
            break;

        case 'actualizar':
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                ProyectosController::editar(
                    $_POST['id'],
                    $_POST['titulo'],
                    $_POST['descripcion'],
                    $_POST['id_cliente'],
                    $_POST['presupuesto'],
                    $_POST['fecha_entrega']
                );
            }
            break;

        case 'pausar':
            if (isset($_GET['id'])) {
                ProyectosController::desactivar($_GET['id']);
            }
            break;

        case 'eliminar':
            if (isset($_GET['id'])) {
                ProyectosController::eliminar($_GET['id']);
            }
            break;

        case 'papelera':
            require_once('./vistas/papelera.php');
            break;

        default:
            include "./vistas/inicio.php";
    }
    ?>

</div>

<?php require_once('./vistas/modulos/footer.php'); ?>

</body>
</html>
