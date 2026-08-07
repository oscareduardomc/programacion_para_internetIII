<?php
session_start();
require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $_SESSION['mensaje'] = "Complete todos los campos.";
        $_SESSION['tipo']    = "danger";
        header("Location: ../index.php");
        exit;
    }

    $query = "
        SELECT id, nombre, email, password, rol
        FROM usuarios
        WHERE email = ?
        LIMIT 1
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        if ($password === $usuario['password']) {

            session_regenerate_id(true);
            $_SESSION['id']     = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['email']  = $usuario['email'];
            $_SESSION['rol']    = $usuario['rol'];
            $_SESSION['logueado'] = true;

            header("Location: ../tickets.php");
            exit;
        } else {
            $_SESSION['mensaje'] = "Credenciales incorrectas.";
            $_SESSION['tipo']    = "danger";
        }
    } else {
        $_SESSION['mensaje'] = "Credenciales incorrectas.";
        $_SESSION['tipo']    = "danger";
    }

    header("Location: ../index.php");
    exit;
} else {
    header("Location: ../index.php");
    exit;
}
?>
