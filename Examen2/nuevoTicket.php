<?php
require "includes/session.php";
require "config/db.php";

if ($_SESSION['rol'] !== 'usuario') {
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
        <a href="tickets.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Regresar
        </a>
    </div>

    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?php echo $_SESSION['tipo']; ?>">
            <?php echo $_SESSION['mensaje']; ?>
        </div>
    <?php
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
    } ?>

    <div class="card">
        <div class="card-body">

            <form action="controllers/guardarTicket.php" method="POST" id="formTicket">

                <div class="row">

                    <div class="col-md-8 mb-3">
                        <label class="form-label">Título <span class="text-danger">*</span></label>
                        <input type="text" name="titulo" id="titulo"
                               class="form-control" placeholder="Resumen breve del problema" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Prioridad <span class="text-danger">*</span></label>
                        <select name="prioridad" class="form-control" required>
                            <option value="Baja">Baja</option>
                            <option value="Media" selected>Media</option>
                            <option value="Alta">Alta</option>
                        </select>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Departamento <span class="text-danger">*</span></label>
                        <input type="text" name="departamento" id="departamento"
                               class="form-control" placeholder="Ej. Ventas, Contabilidad..." required>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Descripción <span class="text-danger">*</span></label>
                        <textarea name="descripcion" id="descripcion" class="form-control"
                                  rows="5" placeholder="Describe el problema con detalle..." required></textarea>
                    </div>

                </div>

                <hr>

                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-paper-plane"></i>
                    Enviar Ticket
                </button>

            </form>

        </div>
    </div>

</div>


<?php include "includes/footer.php"; ?>