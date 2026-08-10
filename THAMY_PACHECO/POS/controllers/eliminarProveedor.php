<?php

session_start();

require "../config/db.php";

if (!isset($_GET['id'])) {

    header("Location: ../proveedores.php");
    exit;
}

$id_proveedor = intval($_GET['id']);

// Validar que exista

$query = "
    SELECT id_proveedor
    FROM proveedores
    WHERE id_proveedor = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_proveedor);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {

    $_SESSION['mensaje'] = "El proveedor no existe.";
    $_SESSION['tipo'] = "warning";

    header("Location: ../proveedores.php");
    exit;
}

// Cambiar estado

$query = "UPDATE proveedores
          SET estado = 0
          WHERE id_proveedor = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_proveedor);

if ($stmt->execute()) {

    $_SESSION['mensaje'] = "Proveedor desactivado correctamente.";
    $_SESSION['tipo'] = "success";

} else {

    $_SESSION['mensaje'] = "Error al desactivar el proveedor.";
    $_SESSION['tipo'] = "danger";
}

header("Location: ../proveedores.php");
exit;
?>
