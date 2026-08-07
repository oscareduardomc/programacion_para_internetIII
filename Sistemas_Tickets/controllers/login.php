<?php
session_start();
require "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login.php");
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($email === '' || $password === '') {
    $_SESSION['mensaje'] = "Complete todos los campos";
    $_SESSION['tipo'] = "danger";
    header("Location: ../login.php");
    exit;
}

$query = "SELECT id, nombre, email, password, rol FROM usuarios WHERE email = ? LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $usuario = $resultado->fetch_assoc();

    if (password_verify($password, $usuario['password'])) {
        session_regenerate_id(true);
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_rol'] = $usuario['rol'];
        $_SESSION['logueado'] = true;
        header("Location: ../dashboard.php");
        exit;
    }
}

$_SESSION['mensaje'] = "Correo o password incorrectos";
$_SESSION['tipo'] = "danger";
header("Location: ../login.php");
exit;
?>