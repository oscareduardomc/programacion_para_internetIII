<?php

session_start();

require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $categoria = trim($_POST['categoria']);
    $descripcion = trim($_POST['descripcion']);

    if (empty($categoria)) {

        $_SESSION['mensaje'] = "Complete todos los campos obligatorios.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../nuevaCategoria.php");
        exit;
    }

    // Verificar categoría existente

    $consulta = "
        SELECT id_categoria
        FROM categorias
        WHERE categoria = ?
    ";

    $stmt = $conn->prepare($consulta);
    $stmt->bind_param("s", $categoria);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {

        $_SESSION['mensaje'] = "La categoría ya existe.";
        $_SESSION['tipo'] = "warning";

        header("Location: ../nuevaCategoria.php");
        exit;
    }

    // Insertar categoría

    $query = "
        INSERT INTO categorias
        (categoria, descripcion, estado)
        VALUES (?, ?, 1)
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $categoria, $descripcion);

    if ($stmt->execute()) {

        $_SESSION['mensaje'] = "Categoría registrada correctamente.";
        $_SESSION['tipo'] = "success";

        header("Location: ../categorias.php");
        exit;

    } else {

        $_SESSION['mensaje'] = "Error al guardar la categoría.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../nuevaCategoria.php");
        exit;
    }

} else {

    header("Location: ../categorias.php");
    exit;
}

$conn->close();
?>
