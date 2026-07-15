<?php
require_once('./controladores/EmpleadosController.php');

// Capturamos la accion que viene por la URL
$action = isset($_GET['action']) ? $_GET['action'] : 'inicio';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <?php 
          // Incluimos el sidebar (cabecera + menu)
            include "./vistas/modulos/sidebar.php";
        ?>
        <?php 
        // Segun la accion mostramos la vista o ejecutamos el metodo
            switch ($action) {

                case 'crear':
                    require_once('./vistas/crear.php');
                    break;
                case 'guardar':
                    if ($_SERVER["REQUEST_METHOD"]== "POST"){
                        EmpleadosController::GuardarEmpleados(
                            $_POST['nombre'],
                            $_POST['puesto'],
                            $_POST['salario'],
                            $_POST['fecha_ingreso'],
                        );

                    }
                    break;

                case 'editar':
                    include "./vistas/editar.php";
                    break;

                case 'eliminar':
                    if(isset($_GET['id'])){
                        EmpleadosController::EliminarEmpleado($_GET['id']);
                    }
                    break;
                default:
                include "./vistas/inicio.php";
            }

        ?>    
        </div>    
        <?php 
        
            // Incluimos el footer (cierre de etiquetas)
            require_once('./vistas/modulos/footer.php');
        
        ?>
   
    
</body>
</html>

