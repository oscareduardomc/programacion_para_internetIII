<?php
require "includes/session.php";
require "config/db.php";

require "includes/header.php";
require "includes/navbar.php";
require "includes/sidebar.php";
?>

<div class="content container mt-4">
    <h3>Nuevo Ticket de Soporte</h3>
    <p class="text-muted">Complete el formulario para registrar una incidencia.</p>

    <form id="formTicket" action="controllers/guardarTicket.php" method="POST">
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Departamento</label>
            <input type="text" name="departamento" id="departamento" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Prioridad</label>
            <select name="prioridad" id="prioridad" class="form-select" required>
                <option value="">Seleccione...</option>
                <option value="Baja">Baja</option>
                <option value="Media">Media</option>
                <option value="Alta">Alta</option>
            </select>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-success">
                Registrar Ticket
            </button>
        </div>
    </form>
</div>

<script>
// Validación básica con JavaScript antes de enviar
document.getElementById("formTicket").addEventListener("submit", function(e){
    const titulo       = document.getElementById("titulo").value.trim();
    const descripcion  = document.getElementById("descripcion").value.trim();
    const departamento = document.getElementById("departamento").value.trim();
    const prioridad    = document.getElementById("prioridad").value;

    if (!titulo || !descripcion || !departamento || !prioridad) {
        alert("Todos los campos son obligatorios.");
        e.preventDefault();
    }
});
</script>

<?php
require "includes/footer.php";
$conn->close();
?>
