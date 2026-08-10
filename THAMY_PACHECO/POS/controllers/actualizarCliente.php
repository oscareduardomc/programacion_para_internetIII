<?php

session_start();

require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id_cliente = intval($_POST['id_cliente']);
    $nombre = trim($_POST['nombre']);
    $identidad = trim($_POST['identidad'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $limite_credito = !empty($_POST['limite_credito']) ? floatval($_POST['limite_credito']) : 0.00;

    if (empty($id_cliente) || empty($nombre)) {

        $_SESSION['mensaje'] = "Complete todos los campos obligatorios.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../editarCliente.php?id=" . $id_cliente);
        exit;
    }

    // Verificar que la identidad no exista en otro registro

    if (!empty($identidad)) {

        $query = "
            SELECT id_cliente
            FROM clientes
            WHERE identidad = ?
            AND id_cliente <> ?
        ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $identidad, $id_cliente);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {

            $_SESSION['mensaje'] = "La identidad ya está registrada.";
            $_SESSION['tipo'] = "warning";

            header("Location: ../editarCliente.php?id=" . $id_cliente);
            exit;
        }
    }

    $query = "
        UPDATE clientes
        SET nombre = ?, identidad = ?, telefono = ?, correo = ?, direccion = ?, limite_credito = ?
        WHERE id_cliente = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssdi", $nombre, $identidad, $telefono, $correo, $direccion, $limite_credito, $id_cliente);

    if ($stmt->execute()) {

        $_SESSION['mensaje'] = "Cliente actualizado correctamente.";
        $_SESSION['tipo'] = "success";

    } else {

        $_SESSION['mensaje'] = "Error al actualizar el cliente.";
        $_SESSION['tipo'] = "danger";
    }

    header("Location: ../clientes.php");
    exit;
}

header("Location: ../clientes.php");
exit;
?>
