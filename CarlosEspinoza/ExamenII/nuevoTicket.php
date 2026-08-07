<?php

require "includes/session.php";
require "config/db.php";

if ($_SESSION['rol'] != 'usuario') {
    header("Location: dashboard.php");
    exit;
}

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-plus"></i>
            Nuevo Ticket
        </h2>
        <a href="dashboard.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Regresar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="formTicket" action="controllers/guardarTicket.php" method="POST">
                <div class="alert alert-danger" id="errorTicket" style="display:none;"></div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Describa brevemente el problema">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Detalle del problema"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Departamento</label>
                        <input type="text" class="form-control" id="departamento" name="departamento" placeholder="Ej. Sistemas, Contabilidad, RRHH">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prioridad</label>
                        <select class="form-select" id="prioridad" name="prioridad">
                            <option value="">Seleccione una prioridad</option>
                            <option value="Baja">Baja</option>
                            <option value="Media">Media</option>
                            <option value="Alta">Alta</option>
                        </select>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i>
                    Guardar Ticket
                </button>
            </form>
        </div>
    </div>
</div>

<script src="assets/js/validarTicket.js"></script>

<?php
include "includes/footer.php";
?>
