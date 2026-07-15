<?php
require_once('./Controller/TallerController');

$action = isset($_GET['action']) ? $_GET['action'] : 'inicio';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Repuestos</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

<?php
switch ($action) {

    case 'crear':
        include "./Vista/crear_repuesto.php";
        break;

    case 'guardar':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            TallerController::guardarRepuesto(
                $_POST['codigo_pieza'],
                $_POST['nombre'],
                $_POST['id_categoria'],
                $_POST['stock'],
                $_POST['precio']
            );
        }
        break;

    case 'editar':
        include "./Vista/editar_repuesto.php";
        break;

    case 'desactivar':
        if (isset($_GET['id'])) {
            TallerController::desactivarRepuesto($_GET['id']);
        }
        break;

    case 'eliminar':
        if (isset($_GET['id'])) {
            TallerController::eliminarRepuesto($_GET['id']);
        }
        break;
    case 'categorias':
        include "./Vista/listar_categorias.php";
        break;

    case 'crear_categoria':
        include "./Vista/crear_categoria.php";
        break;

    case 'guardar_categoria':
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            TallerController::guardarCategoria(
                $_POST['nombre_categoria'],
                $_POST['descripcion']
            );
        }
        break;
    default:
        include "./Vista/listar_respuestos.php";
        break;
}
?>

</div>

</body>
</html>