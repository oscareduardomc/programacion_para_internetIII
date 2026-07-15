<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Control de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <nav class="col-md-2 d-md-block bg-dark sidebar min-vh-100 p-3">
            <div class="text-white text-center mb-4">
                <h5 class="fw-bold">TechSolutions</h5>
                <small>Control de Empleados</small>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="index.php">
                        Ver Lista
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="index.php?action=crear">
                        Agregar Empleado
                    </a>
                </li>
            </ul>
        </nav>

        <main class="col-md-10 p-4">