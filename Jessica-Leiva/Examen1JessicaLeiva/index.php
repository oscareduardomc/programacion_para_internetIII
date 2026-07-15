<?php
require_once 'controllers/VehiculoController.php';
$action = isset($_GET['action']) ? $_GET['action'] : 'inicio';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Vehículos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

<div class="d-flex">

    <?php include "views/modulos/sidebar.php";?>

    <?php

    switch($action){

        case 'crear':
            include "views/crear.php";
        break;

        case 'editar':
            include "views/editar.php";
        break;
        
        case 'vender':
            if(isset($_GET['id'])){
                VehiculoController::vender($_GET['id']);
            }
        break;

        case 'eliminar':
            if(isset($_GET['id'])){
                VehiculoController::eliminar($_GET['id']);
            }
        break;

        default:
            include "views/inicio.php";
        break;

    }

    ?>

    <?php include "views/modulos/footer.php";?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>