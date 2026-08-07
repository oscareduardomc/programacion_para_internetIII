<?php
session_start();

if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    $_SESSION['mensaje'] = "Debe iniciar sesión.";
    $_SESSION['tipo']    = "danger";
    header("Location: index.php");
    exit;
}
?>
