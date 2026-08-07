<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['rol'] == 'tecnico') {
    $id = $_POST['id'];
    $estado = $_POST['estado'];

    $sql = "UPDATE tickets SET estado = '$estado' WHERE id = '$id'";
    $conn->query($sql);
}

header("Location: dashboard.php");
exit();
?>