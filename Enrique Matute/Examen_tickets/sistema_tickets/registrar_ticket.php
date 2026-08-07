<?php
 error_reporting(E_ALL); ini_set('display_errors', 1); 
require "includes/session.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Ticket</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>
        body { background-color: #f4f6f9; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-primary px-3">
    <span class="navbar-brand mb-0 h1"><i class="fa-solid fa-headset"></i> Sistema de Tickets</span>
    <div class="text-white">
        <?= htmlspecialchars($_SESSION['nombre']) ?>
        <a href="logout.php" class="btn btn-outline-light btn-sm ms-3">
            <i class="fa-solid fa-right-from-bracket"></i> Salir
        </a>
    </div>
</nav>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><i class="fa-solid fa-ticket"></i> Nuevo Ticket</h4>
        <a href="listado.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Regresar
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger py-2">
                    Todos los campos son obligatorios.
                </div>
            <?php endif; ?>

            <form id="formTicket" action="controllers/guardar_ticket.php" method="POST" novalidate>

                <div class="mb-3">
                    <label class="form-label">Titulo</label>
                    <input type="text" name="txtTitulo" id="txtTitulo" class="form-control" placeholder="Ej: No enciende el monitor">
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripcion</label>
                    <textarea name="txtDescripcion" id="txtDescripcion" class="form-control" rows="4" placeholder="Describa el problema"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Departamento</label>
                        <select name="txtDepartamento" id="txtDepartamento" class="form-select">
                            <option value="">Seleccione...</option>
                            <option value="Administracion">Administracion</option>
                            <option value="Ventas">Ventas</option>
                            <option value="Sistemas">Sistemas</option>
                            <option value="Recepcion">Recepcion</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prioridad</label>
                        <select name="txtPrioridad" id="txtPrioridad" class="form-select">
                            <option value="">Seleccione...</option>
                            <option value="Baja">Baja</option>
                            <option value="Media">Media</option>
                            <option value="Alta">Alta</option>
                        </select>
                    </div>
                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Ticket
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="assets/js/validacion.js"></script>
</body>
</html>