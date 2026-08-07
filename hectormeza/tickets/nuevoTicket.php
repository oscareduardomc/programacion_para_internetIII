<?php

require "includes/session.php";

// Solo el rol usuario puede crear tickets
if ($_SESSION['rol'] !== 'usuario'){
    header("Location: tickets.php");
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
        <a href="tickets.php" class="btn btn-secondary btn-sm">
            <i class="fa-solid fa-arrow-left"></i>
            Volver
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <form action="controllers/guardarTicket.php" method="POST" id="formTicket" novalidate>

                <div class="mb-3">
                    <label class="form-label">Titulo</label>
                    <input type="text" name="titulo" id="titulo" class="form-control"
                    placeholder="Ejemplo: No puedo acceder al sistema">
                    <div class="invalid-feedback" id="errorTitulo"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripcion</label>
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="4"
                    placeholder="Describa el problema"></textarea>
                    <div class="invalid-feedback" id="errorDescripcion"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Departamento</label>
                    <select name="departamento" id="departamento" class="form-select">
                        <option value="">Seleccione un departamento</option>
                        <option value="Sistemas">Sistemas</option>
                        <option value="Soporte Tecnico">Soporte Tecnico</option>
                        <option value="Contabilidad">Contabilidad</option>
                        <option value="Recursos Humanos">Recursos Humanos</option>
                        <option value="Ventas">Ventas</option>
                    </select>
                    <div class="invalid-feedback" id="errorDepartamento"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prioridad</label>
                    <select name="prioridad" id="prioridad" class="form-select">
                        <option value="">Seleccione una prioridad</option>
                        <option value="Baja">Baja</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>
                    <div class="invalid-feedback" id="errorPrioridad"></div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-paper-plane"></i>
                        Enviar Solicitud
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<script src="assets/js/validaciones.js"></script>

<?php
include "includes/footer.php";
?>
