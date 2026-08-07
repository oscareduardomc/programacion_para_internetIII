<?php
session_start();
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

session_start();
$_SESSION['mensaje'] = "Has cerrado sesión correctamente.";
$_SESSION['tipo'] = "info";

header("Location: login.php");
exit;
?>
