<?php
    if (session_status() === PHP_SESSION_NONE){
        session_start();
    }
    if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true){
        header("Location: login.php");
        exit;
    }
?>
