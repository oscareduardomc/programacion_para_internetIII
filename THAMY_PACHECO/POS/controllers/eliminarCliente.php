<?php

session_start();

require "../config/db.php";

if (!isset($_GET['id'])) {

    header("Location: ../clientes.php");
    exit;
}

$id_cliente = intval($_GET['id']);

// Validar que exista

$query = "
    SELECT id_cliente
    FROM clientes
    WHERE id_cliente = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_cliente);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {

    $_SESSION['mensaje'] = "El cliente no existe.";
    $_SESSION['tipo'] = "warning";

    header("Location: ../clientes.php");
    exit;
}

// Cambiar estado

$query = "UPDATE clientes
          SET estado = 0
          WHERE id_cliente = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_cliente);

if ($stmt->execute()) {

    $_SESSION['mensaje'] = "Cliente desactivado correctamente.";
    $_SESSION['tipo'] = "success";

} else {

    $_SESSION['mensaje'] = "Error al desactivar el cliente.";
    $_SESSION['tipo'] = "danger";
}

header("Location: ../clientes.php");
exit;
?>
