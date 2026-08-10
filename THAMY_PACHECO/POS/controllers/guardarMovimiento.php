<?php
session_start();
require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id_producto     = intval($_POST['id_producto']);
    $tipo_movimiento = trim($_POST['tipo_movimiento']);
    $cantidad        = floatval($_POST['cantidad']);
    $motivo          = trim($_POST['motivo']);
    $id_usuario      = intval($_SESSION['id_usuario']);

    // Para validaciones básicas
    if (empty($id_producto) || empty($tipo_movimiento) || $cantidad <= 0 || empty($motivo)) {
        $_SESSION['mensaje'] = "Por favor llene todos los campos obligatorios.";
        $_SESSION['tipo'] = "danger";
        header("Location: ../movimientosCaja.php");
        exit;
    }

    // Para obtener el stock actual del producto
    $query_prod = "SELECT stock FROM productos WHERE id_producto = ?";
    $stmt_prod = $conn->prepare($query_prod);
    $stmt_prod->bind_param("i", $id_producto);
    $stmt_prod->execute();
    $res_prod = $stmt_prod->get_result();

    if ($res_prod->num_rows == 0) {
        $_SESSION['mensaje'] = "El producto seleccionado no existe.";
        $_SESSION['tipo'] = "danger";
        header("Location: ../movimientosCaja.php");
        exit;
    }

    $prod = $res_prod->fetch_assoc();
    $stock_anterior = floatval($prod['stock']);
    $stock_nuevo = $stock_anterior;

    // Para calcular el nuevo stock según el tipo
    if ($tipo_movimiento == "ENTRADA") {
        $stock_nuevo = $stock_anterior + $cantidad;
    } elseif ($tipo_movimiento == "SALIDA") {
        if ($cantidad > $stock_anterior) {
            $_SESSION['mensaje'] = "La cantidad a retirar supera el stock actual (Stock actual: $stock_anterior).";
            $_SESSION['tipo'] = "warning";
            header("Location: ../movimientosCaja.php");
            exit;
        }
        $stock_nuevo = $stock_anterior - $cantidad;
    } elseif ($tipo_movimiento == "AJUSTE") {
        $stock_nuevo = $stock_anterior;
    } else {
        $_SESSION['mensaje'] = "Tipo de movimiento no válido.";
        $_SESSION['tipo'] = "danger";
        header("Location: ../movimientosCaja.php");
        exit;
    }

    // Iniciar Transacción
    $conn->begin_transaction();

    try {
        // 1. Insertar el movimiento
        $query_ins = "INSERT INTO movimientos_inventario 
                      (id_producto, id_usuario, tipo_movimiento, cantidad, stock_anterior, stock_nuevo, motivo) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_ins = $conn->prepare($query_ins);
        $stmt_ins->bind_param("iisddds", $id_producto, $id_usuario, $tipo_movimiento, $cantidad, $stock_anterior, $stock_nuevo, $motivo);
        $stmt_ins->execute();

        // 2. Actualizar el stock en la tabla productos
        $query_upd = "UPDATE productos SET stock = ? WHERE id_producto = ?";
        $stmt_upd = $conn->prepare($query_upd);
        $stmt_upd->bind_param("di", $stock_nuevo, $id_producto);
        $stmt_upd->execute();

        // Confirmar transacción
        $conn->commit();

        $_SESSION['mensaje'] = "Movimiento registrado y stock actualizado correctamente.";
        $_SESSION['tipo'] = "success";

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['mensaje'] = "Error al registrar el movimiento: " . $e->getMessage();
        $_SESSION['tipo'] = "danger";
    }

    header("Location: ../movimientosCaja.php");
    exit;
}

header("Location: ../movimientosCaja.php");
exit;