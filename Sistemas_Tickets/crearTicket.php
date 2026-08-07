<?php
require "includes/session.php";
require "config/db.php";

if ($_SESSION['usuario_rol'] !== 'usuario') {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $prioridad = $_POST['prioridad'] ?? '';
    $id_usuario = $_SESSION['usuario_id'];

    if ($titulo === '' || $descripcion === '' || !in_array($prioridad, ['Baja', 'Media', 'Alta'], true)) {
        $error = "Complete todos los campos correctamente";
    } else {
        $query = "INSERT INTO tickets
                  (id_usuario, titulo, descripcion, prioridad)
                  VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("isss", $id_usuario, $titulo, $descripcion, $prioridad);
        $stmt->execute();

        $_SESSION['mensaje'] = "Ticket creado correctamente";
        $_SESSION['tipo'] = "success";

        header("Location: tickets.php");
        exit;
    }
}

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";
?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            Crear Ticket
        </h2>

        <a href="tickets.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Volver
        </a>
    </div>

    <?php if (isset($error)) { ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php } ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" id="formTicket" novalidate>
                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" name="titulo" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="5"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prioridad</label>
                    <select name="prioridad" class="form-select">
                        <option value="">Seleccione una prioridad</option>
                        <option value="Baja">Baja</option>
                        <option value="Media">Media</option>
                        <option value="Alta">Alta</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i>
                    Guardar Ticket
                </button>
            </form>
        </div>
    </div>
</div>

<script src="assets/js/usuario.js"></script>
<?php include "includes/footer.php"; ?>