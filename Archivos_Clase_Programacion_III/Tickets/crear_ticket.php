<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_SESSION['rol'] == 'usuario') {
    $user_id = $_SESSION['user_id'];
    $titulo = $_POST['titulo'];
    $departamento = $_POST['departamento'];
    $prioridad = $_POST['prioridad'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO tickets (id_usuario, titulo, departamento, prioridad, descripcion) 
            VALUES ('$user_id', '$titulo', '$departamento', '$prioridad', '$descripcion')";
    
    $conn->query($sql);
}

header("Location: dashboard.php");
exit();
?>