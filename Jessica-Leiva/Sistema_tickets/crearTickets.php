<?php
require "includes/session.php";
require "config/db.php";

$rol = $_SESSION['rol'];
if ($rol !== 'usuario') {
  header("Location: tickets.php");
  exit;
}

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>
<div class="content">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <a href="tickets.php" class="btn btn-secondary">
      <i class="fa-solid fa-arrow-left"></i>
      Regresar
    </a>
  </div>
  <form action="controllers/crearTickets.php" method="POST">
    <div id="formulacionTicket" class="content">


      <div class="col-md-6 mb-3">
        <label for="" class="form-label">Titulo</label>
        <input type="text" class="form-control" name="titulo" placeholder="Ingrese el titulo">
      </div>
      <div class="col-md-6 mb-3">
        <label for="" class="form-label">Descripcion</label>
        <input type="text" class="form-control" name="descripcion" placeholder="Descripcion">
      </div>
      <div class="mb-3">
        <label class="form-label">Prioridad</label>
        <select name="prioridad" class="form-control">
          <option value="">Seleccione...</option>
          <option value="Baja">Baja</option>
          <option value="Media">Media</option>
          <option value="Alta">Alta</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">
        <i class="fa-solid fa-save"></i>
        Crear Ticket
      </button>
  </form>
</div>
</div>
</div>
<script src="assets/js/crearTicket.js"></script>

<?php include "includes/footer.php"; ?>