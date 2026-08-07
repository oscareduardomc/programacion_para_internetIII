<?php

session_start();

if (isset($_SESSION['usuario_logueado']) 
) {
    header("Location: dashboard.php");
    exit;
}

require "../config/db.php";
$id = $_POST['id'];
$estado = $_POST['estado'];

$query = "UPDATE tickets
          SET estado = ?
          WHERE id = ?";
          
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $estado, $id);
$stmt->execute();

header("Location: ../tickets.php");
exit;

?>