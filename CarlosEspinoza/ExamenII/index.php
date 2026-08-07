<?php
session_start();

if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true) {
    header("Location: dashboard.php");
    exit;
}

header("Location: login.php");
exit;
?>
