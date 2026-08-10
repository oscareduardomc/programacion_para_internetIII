<?php

session_start();

require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id_proveedor = intval($_POST['id_proveedor']);
    $nombre = trim($_POST['nombre']);
    $contacto = trim($_POST['contacto'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');

    if (empty($id_proveedor) || empty($nombre)) {

        $_SESSION['mensaje'] = "Complete todos los campos obligatorios.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../editarProveedor.php?id=" . $id_proveedor);
        exit;
    }

    $query = "
        UPDATE proveedores
        SET nombre = ?, contacto = ?, telefono = ?, email = ?, direccion = ?
        WHERE id_proveedor = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nombre, $contacto, $telefono, $email, $direccion, $id_proveedor);

    if ($stmt->execute()) {

        $_SESSION['mensaje'] = "Proveedor actualizado correctamente.";
        $_SESSION['tipo'] = "success";

    } else {

        $_SESSION['mensaje'] = "Error al actualizar el proveedor.";
        $_SESSION['tipo'] = "danger";
    }

    header("Location: ../proveedores.php");
    exit;
}

header("Location: ../proveedores.php");
exit;
?>
