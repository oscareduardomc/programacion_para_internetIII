<?php

session_start();

require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $nombre = trim($_POST['nombre']);
    $contacto = trim($_POST['contacto'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');

    if (empty($nombre)) {

        $_SESSION['mensaje'] = "Complete todos los campos obligatorios.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../nuevoProveedor.php");
        exit;
    }

    // Insertar proveedor

    $query = "
        INSERT INTO proveedores
        (nombre, contacto, telefono, email, direccion, estado)
        VALUES (?, ?, ?, ?, ?, 1)
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $nombre, $contacto, $telefono, $email, $direccion);

    if ($stmt->execute()) {

        $_SESSION['mensaje'] = "Proveedor registrado correctamente.";
        $_SESSION['tipo'] = "success";

        header("Location: ../proveedores.php");
        exit;

    } else {

        $_SESSION['mensaje'] = "Error al guardar el proveedor.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../nuevoProveedor.php");
        exit;
    }

} else {

    header("Location: ../proveedores.php");
    exit;
}

$conn->close();
?>
