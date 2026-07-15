<?php
    require_once "config/conexion.php";
    require_once "controllers/RepuestoController.php";
    require_once "controllers/CategoriaController.php";
    $action = isset($_GET['action']) ? $_GET['action'] : 'inicio';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Repuestos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
    <?php include "views/models/sidebar.php"; ?>

    <?php
        switch ($action){
            case 'crear':
                include "views/crear.php";
                break;
            case 'editar':
                include "views/editar.php";
                break;
            case 'desactivar':
                if(isset($_GET['id'])){
                    RepuestoController::desactivar($_GET['id']);
                }
                break;
            case 'eliminar':
                if(isset($_GET['id'])){
                    RepuestoController::eliminar($_GET['id']);
                }
                break;
            case 'categorias':
                include "views/categorias/categorias.php";
                break;
            case 'crearCategoria':
                include "views/categorias/crearCategoria.php";
                break;
            case 'editarCategoria':
                include "views/categoria/editarCategoria.php";
                break;
            case 'desactivarCategoria':
                if(isset($_GET['id'])){
                    CategoriaController::desactivar($_GET['id']);
                }
                break;
            case 'eliminarCategoria':
                if(isset($_GET['id'])){
                    CategoriaController::eliminar($_GET['id']);
                }
                break;
            default:
                include "views/inicio.php";
                break;
        }
    ?>

    <?php include "views/models/footer.php"; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
