<?php
require "includes/session.php";

if (($_SESSION['rol'] ?? '') !== 'usuario') {
    header("Location: dashboard.php");
    exit;
}

include "includes/header.php";
include "includes/navbar.php";
include "includes/sidebar.php";
?>

<div class="content">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-plus me-2"></i>Registrar nuevo ticket
                    </h5>
                </div>
                <div class="card-body">
                    <div id="erroresValidacion" class="alert alert-danger errores-validacion">
                        <ul id="listaErrores" class="mb-0"></ul>
                    </div>

                    <form action="controllers/crearTicket.php" method="POST" id="formTicket" novalidate>
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título *</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" maxlength="200" placeholder="Resumen breve del problema">
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción *</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" rows="4" placeholder="Describa el problema con detalle"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="departamento" class="form-label">Departamento *</label>
                            <select name="departamento" id="departamento" class="form-select">
                                <option value="">Seleccione un departamento</option>
                                <option value="Sistemas">Sistemas</option>
                                <option value="Administración">Administración</option>
                                <option value="Ventas">Ventas</option>
                                <option value="Recursos Humanos">Recursos Humanos</option>
                                <option value="Contabilidad">Contabilidad</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="prioridad" class="form-label">Prioridad *</label>
                            <select name="prioridad" id="prioridad" class="form-select">
                                <option value="">Seleccione la prioridad</option>
                                <option value="Baja">Baja</option>
                                <option value="Media">Media</option>
                                <option value="Alta">Alta</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa-solid fa-paper-plane me-1"></i>Enviar ticket
                            </button>
                            <a href="dashboard.php" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/validarTicket.js"></script>
<?php include "includes/footer.php"; ?>
