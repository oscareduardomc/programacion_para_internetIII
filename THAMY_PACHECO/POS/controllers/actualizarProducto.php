<?php

session_start();

require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id_producto = intval($_POST['id_producto']);
    $codigo = trim($_POST['codigo']);
    $nombre = trim($_POST['nombre']);
    $id_categoria = !empty($_POST['id_categoria']) ? intval($_POST['id_categoria']) : null;
    $stock = intval($_POST['stock']);
    $stock_minimo = !empty($_POST['stock_minimo']) ? intval($_POST['stock_minimo']) : 5;
    $precio_costo = floatval($_POST['precio_costo']);
    $precio_venta = floatval($_POST['precio_venta']);

    if (empty($id_producto) || empty($codigo) || empty($nombre) || $id_categoria === null) {

        $_SESSION['mensaje'] = "Complete todos los campos obligatorios.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../editarProducto.php?id=" . $id_producto);
        exit;
    }

    // Verificar que el código no exista en otro registro

    $query = "
        SELECT id_producto
        FROM productos
        WHERE codigo = ?
        AND id_producto <> ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $codigo, $id_producto);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {

        $_SESSION['mensaje'] = "El código de producto ya existe.";
        $_SESSION['tipo'] = "warning";

        header("Location: ../editarProducto.php?id=" . $id_producto);
        exit;
    }

    $query = "
        UPDATE productos
        SET codigo = ?, nombre = ?, id_categoria = ?, precio_costo = ?, precio_venta = ?, stock = ?, stock_minimo = ?
        WHERE id_producto = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssiddiii", $codigo, $nombre, $id_categoria, $precio_costo, $precio_venta, $stock, $stock_minimo, $id_producto);

    if ($stmt->execute()) {

        $_SESSION['mensaje'] = "Producto actualizado correctamente.";
        $_SESSION['tipo'] = "success";

    } else {

        $_SESSION['mensaje'] = "Error al actualizar el producto.";
        $_SESSION['tipo'] = "danger";
    }

    header("Location: ../productos.php");
    exit;
}

header("Location: ../productos.php");
exit;
?>
