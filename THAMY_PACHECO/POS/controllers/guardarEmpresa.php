<?php

session_start();

require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $nombre = trim($_POST['nombre']);
    $rtn = trim($_POST['rtn'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $pie_factura = trim($_POST['pie_factura'] ?? '');

    if (empty($nombre)) {

        $_SESSION['mensaje'] = "El nombre de la empresa es obligatorio.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../empresa.php");
        exit;
    }

    // Verificar si ya existe un registro de empresa

    $query = "SELECT id_empresa FROM empresa ORDER BY id_empresa ASC LIMIT 1";
    $resultado = $conn->query($query);
    $existe = $resultado->fetch_assoc();

    if ($existe) {

        $query = "
            UPDATE empresa
            SET nombre = ?, rtn = ?, telefono = ?, correo = ?, direccion = ?, pie_factura = ?
            WHERE id_empresa = ?
        ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssi", $nombre, $rtn, $telefono, $correo, $direccion, $pie_factura, $existe['id_empresa']);

    } else {

        $query = "
            INSERT INTO empresa
            (nombre, rtn, telefono, correo, direccion, pie_factura, estado)
            VALUES (?, ?, ?, ?, ?, ?, 1)
        ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $nombre, $rtn, $telefono, $correo, $direccion, $pie_factura);
    }

    if ($stmt->execute()) {

        $_SESSION['mensaje'] = "Datos de la empresa actualizados correctamente.";
        $_SESSION['tipo'] = "success";

    } else {

        $_SESSION['mensaje'] = "Error al guardar los datos de la empresa.";
        $_SESSION['tipo'] = "danger";
    }

    header("Location: ../empresa.php");
    exit;
}

header("Location: ../empresa.php");
exit;
?>
