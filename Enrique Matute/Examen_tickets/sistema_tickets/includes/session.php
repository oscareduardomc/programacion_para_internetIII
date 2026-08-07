<?php
// Inicia o continua la sesion
session_start();

// Si no hay sesion activa, regresa al login
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}
?>