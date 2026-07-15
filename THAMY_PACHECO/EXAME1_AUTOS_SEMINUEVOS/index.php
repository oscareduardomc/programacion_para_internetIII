<?php
    require_once "controladores/AutosControlador.php";
    $action = isset($_GET['action']) ? $_GET['action'] : 'inicio';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTOS SEMINUEVOS</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <?php 
            include "vistas/modulos/sidebar.php";
        ?>

        <!-- Contenido principal y ruteo -->
        <div class="container mt-4">
            <!-- Sección de Alertas -->
            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php 
                switch ($action){
                    case 'crear':
                        include "vistas/crear.php";
                        break;
                    case 'editar':
                        include "vistas/editar.php";
                        break;
                    case 'eliminar_marca':
                        if (isset($_GET['id'])){
                            AutosControlador::ELIMINAR_MARCA($_GET['id']);
                        }
                        break;
                    case 'desactivar_vehiculo':
                        if (isset($_GET['id'])){
                            AutosControlador::DESACTIVAR_VEHICULO($_GET['id']);
                        }
                        break;
                    case 'activar_vehiculo':
                        if (isset($_GET['id'])){
                            AutosControlador::ACTIVAR_VEHICULO($_GET['id']);
                        }
                        break;
                    case 'eliminar_vehiculo':
                        if (isset($_GET['id'])){
                            AutosControlador::ELIMINAR_VEHICULO($_GET['id']);
                        }
                        break;
                    default:
                        include "vistas/inicio.php";
                        break;
                }
            ?>
        </div>

        <?php
            include "vistas/modulos/footer.php";
        ?>
    </div>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>