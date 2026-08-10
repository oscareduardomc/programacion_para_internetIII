<?php

session_start();

require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $nombre = trim($_POST['nombre']);
    $identidad = trim($_POST['identidad'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $limite_credito = !empty($_POST['limite_credito']) ? floatval($_POST['limite_credito']) : 0.00;
    $saldo_credito = 0.00;

    if (empty($nombre)) {

        $_SESSION['mensaje'] = "Complete todos los campos obligatorios.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../ingresarCliente.php");
        exit;
    }

    // Verificar identidad existente

    if (!empty($identidad)) {

        $consulta = "
            SELECT id_cliente
            FROM clientes
            WHERE identidad = ?
        ";

        $stmt = $conn->prepare($consulta);
        $stmt->bind_param("s", $identidad);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {

            $_SESSION['mensaje'] = "La identidad ya está registrada.";
            $_SESSION['tipo'] = "warning";

            header("Location: ../ingresarCliente.php");
            exit;
        }
    }

    // Insertar cliente

    $query = "
        INSERT INTO clientes
        (nombre, identidad, telefono, correo, direccion, limite_credito, saldo_credito, estado)
        VALUES (?, ?, ?, ?, ?, ?, ?, 1)
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssdd", $nombre, $identidad, $telefono, $correo, $direccion, $limite_credito, $saldo_credito);

    if ($stmt->execute()) {

        $_SESSION['mensaje'] = "Cliente registrado correctamente.";
        $_SESSION['tipo'] = "success";

        header("Location: ../clientes.php");
        exit;

    } else {

        $_SESSION['mensaje'] = "Error al guardar el cliente.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../ingresarCliente.php");
        exit;
    }

} else {

    header("Location: ../clientes.php");
    exit;
}

$conn->close();
?>
