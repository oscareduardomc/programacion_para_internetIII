<?php
// 1. Incluir la conexión
include "conexion.php";

// 2. Capturar la acción solicitada por la URL ($_GET para vistas)
$accion = isset($_GET['action']) ? $_GET['action'] : "listar";

// 3. Según la acción, cargar el archivo correspondiente
switch ($accion) {
    case "listar":
        include "listar.php";
        break;
    case "crear":
        include "crear.php";
        break;
    case "guardar":
        include "guardar.php";
        break;
    case "editar":
        include "editar.php";
        break;
    case "actualizar":
        include "actualizar.php";
        break;
    case "desactivar":   // Soft delete
        include "desactivar.php";
        break;
    case "eliminar":     // Hard delete
        include "eliminar.php";
        break;
    default:
        include "listar.php";
        break;
}
?>
