<?php

session_start();

require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $codigo = trim($_POST['codigo']);
    $nombre = trim($_POST['nombre']);
    $id_categoria = !empty($_POST['id_categoria']) ? intval($_POST['id_categoria']) : null;
    $stock = intval($_POST['stock']);
    $stock_minimo = !empty($_POST['stock_minimo']) ? intval($_POST['stock_minimo']) : 5;
    $precio_costo = floatval($_POST['precio_costo']);
    $precio_venta = floatval($_POST['precio_venta']);

    if (empty($codigo) || empty($nombre) || $id_categoria === null) {

        $_SESSION['mensaje'] = "Complete todos los campos obligatorios.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../nuevoProducto.php");
        exit;
    }

    // Verificar código existente

    $consulta = "
        SELECT id_producto
        FROM productos
        WHERE codigo = ?
    ";

    $stmt = $conn->prepare($consulta);
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {

        $_SESSION['mensaje'] = "El código de producto ya existe.";
        $_SESSION['tipo'] = "warning";

        header("Location: ../nuevoProducto.php");
        exit;
    }

    // Insertar producto

    $query = "
        INSERT INTO productos
        (codigo, nombre, id_categoria, precio_costo, precio_venta, stock, stock_minimo, estado)
        VALUES (?, ?, ?, ?, ?, ?, ?, 1)
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssiddii", $codigo, $nombre, $id_categoria, $precio_costo, $precio_venta, $stock, $stock_minimo);

    if ($stmt->execute()) {

        $_SESSION['mensaje'] = "Producto registrado correctamente.";
        $_SESSION['tipo'] = "success";

        header("Location: ../productos.php");
        exit;

    } else {

        $_SESSION['mensaje'] = "Error al guardar el producto.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../nuevoProducto.php");
        exit;
    }

} else {

    header("Location: ../productos.php");
    exit;
}

$conn->close();
?>
