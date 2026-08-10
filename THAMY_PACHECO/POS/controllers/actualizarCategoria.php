<?php

session_start();

require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id_categoria = intval($_POST['id_categoria']);
    $categoria = trim($_POST['categoria']);
    $descripcion = trim($_POST['descripcion']);

    if (empty($id_categoria) || empty($categoria)) {

        $_SESSION['mensaje'] = "Complete todos los campos obligatorios.";
        $_SESSION['tipo'] = "danger";

        header("Location: ../editarCategoria.php?id=" . $id_categoria);
        exit;
    }

    // Verificar que la categoría no exista en otro registro

    $query = "
        SELECT id_categoria
        FROM categorias
        WHERE categoria = ?
        AND id_categoria <> ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $categoria, $id_categoria);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {

        $_SESSION['mensaje'] = "La categoría ya existe.";
        $_SESSION['tipo'] = "warning";

        header("Location: ../editarCategoria.php?id=" . $id_categoria);
        exit;
    }

    $query = "
        UPDATE categorias
        SET categoria = ?, descripcion = ?
        WHERE id_categoria = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $categoria, $descripcion, $id_categoria);

    if ($stmt->execute()) {

        $_SESSION['mensaje'] = "Categoría actualizada correctamente.";
        $_SESSION['tipo'] = "success";

    } else {

        $_SESSION['mensaje'] = "Error al actualizar la categoría.";
        $_SESSION['tipo'] = "danger";
    }

    header("Location: ../categorias.php");
    exit;
}

header("Location: ../categorias.php");
exit;
?>
