<?php
require_once __DIR__ . '/config/conexion.php';
require_once __DIR__ . '/controladores/EmpleadoController.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'listar';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TECHSOLUTIONS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="d-flex">
        <?php
        switch ($action) {
            case 'guardar':
                $resultado = EmpleadoController::guardar($_POST['nombre'], $_POST['puesto'], $_POST['salario']);
                if ($resultado) echo $resultado;
                break;

            case 'actualizar':
                $resultado = EmpleadoController::actualizar($_POST['id'], $_POST['nombre'], $_POST['puesto'], $_POST['salario'], $_POST['activo']);
                if ($resultado) echo $resultado;
                break;

            case 'cambiar_estado':
                $resultado = EmpleadoController::cambiarEstado($_GET['id'], $_GET['estado']);
                if ($resultado) echo $resultado;
                break;

            case 'eliminar':
                $resultado = EmpleadoController::eliminar($_GET['id']);
                if ($resultado) echo $resultado;
                break;

            case 'crear':
                include 'vistas/modulos/sidebar.php';
                include 'vistas/crear.php';
                include 'vistas/modulos/footer.php';
                break;

            case 'editar':
                include 'vistas/modulos/sidebar.php';
                include 'vistas/editar.php';
                include 'vistas/modulos/footer.php';
                break;

            default:
                include 'vistas/modulos/sidebar.php';
                include 'vistas/inicio.php';
                include 'vistas/modulos/footer.php';
                break;
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>