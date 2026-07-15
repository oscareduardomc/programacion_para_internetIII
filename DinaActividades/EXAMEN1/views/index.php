<?php
require_once '../controllers/RepuestoControllers.php';


if (isset($_GET['action']) && $_GET['action'] == 'desactivar' && isset($_GET['id'])) {
    RepuestoControllers::desactivar($_GET['id']);
}
if (isset($_GET['action']) && $_GET['action'] == 'eliminar' && isset($_GET['id'])) {
    RepuestoControllers::eliminar($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>examen1</title>

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

<div class="d-flex">
  <?php
  include "modulos/sidebar.php";
  $action = isset($_GET['action']) ? $_GET['action'] : 'inicio';
switch ($action) {
    case 'inicio':
        include "inicio.php";
        break;
    case 'crear':
        include "crear.php";
        break;
    case 'editar':
        include "editar.php";
        break;
    default:
        include "inicio.php";
        break;
}
include "modulos/footer.php";
  ?>

  </div>
</body>
</html>