<?php
// ============================================
// CONTROLADOR LOGOUT
// Cierra la sesión y redirige al login
// ============================================

session_start(); // Inicia la sesión para poder destruirla

session_destroy(); // Elimina todas las variables de sesión

// Redirige al login
header("Location: ../index.php");
exit;
?>
