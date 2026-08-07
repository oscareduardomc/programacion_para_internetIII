<?php
    session_start();

    //Eliminar todas las variables de sesion
    $_SESSION = array();

    //Si existe una cookie de sesion, tambien la eliminamos
    if (ini_get("session.use_cookies")){
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Destruir la sesion
    session_destroy();
    // Redirigir al login
    header("Location: login.php");
    exit;
?>
