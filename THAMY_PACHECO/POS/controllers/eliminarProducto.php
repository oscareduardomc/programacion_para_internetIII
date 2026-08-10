<?php

session_start();

require "../config/db.php";

if (!isset($_GET['id'])) {

    header("Location: ../productos.php");
    exit;
}

$id_producto = intval($_GET['id']);

// Validar que exista

$query = "
    SELECT id_producto
    FROM productos
    WHERE id_producto = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {

    $_SESSION['mensaje'] = "El producto no existe.";
    $_SESSION['tipo'] = "warning";

    header("Location: ../productos.php");
    exit;
}

// Cambiar estado

$query = "UPDATE productos
          SET estado = 0
          WHERE id_producto = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_producto);

if ($stmt->execute()) {

    $_SESSION['mensaje'] = "Producto desactivado correctamente.";
    $_SESSION['tipo'] = "success";

} else {

    $_SESSION['mensaje'] = "Error al desactivar el producto.";
    $_SESSION['tipo'] = "danger";
}

header("Location: ../productos.php");
exit;
?>
