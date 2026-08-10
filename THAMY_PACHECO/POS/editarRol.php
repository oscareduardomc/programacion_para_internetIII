<?php

require "includes/session.php";
require "config/db.php";

if (!isset($_GET['id'])) {
    header("Location: roles.php");
    exit;
}

$id_rol = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $nombre      = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $estado      = intval($_POST['estado']);

    if (empty($nombre)) {
        $_SESSION['mensaje'] = "El nombre del rol es obligatorio.";
        $_SESSION['tipo']    = "danger";
        header("Location: editarRol.php?id=" . $id_rol);
        exit;
    }

    $stmt = $conn->prepare("SELECT id_rol FROM roles WHERE nombre = ? AND id_rol <> ?");
    $stmt->bind_param("si", $nombre, $id_rol);
    $stmt->execute();

    if ($stmt->get_result()->num_rows > 0) {
        $_SESSION['mensaje'] = "Ya existe un rol con ese nombre.";
        $_SESSION['tipo']    = "warning";
        header("Location: editarRol.php?id=" . $id_rol);
        exit;
    }

  
    $stmt = $conn->prepare("UPDATE roles SET nombre = ?, descripcion = ?, estado = ? WHERE id_rol = ?");
    $stmt->bind_param("ssii", $nombre, $descripcion, $estado, $id_rol);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Rol actualizado correctamente.";
        $_SESSION['tipo']    = "success";
    } else {
        $_SESSION['mensaje'] = "Error al actualizar el rol.";
        $_SESSION['tipo']    = "danger";
    }

    header("Location: roles.php");
    exit;
}


$stmt = $conn->prepare("SELECT * FROM roles WHERE id_rol = ?");
$stmt->bind_param("i", $id_rol);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    header("Location: roles.php");
    exit;
}

$rol = $resultado->fetch_assoc();

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>

<div class="content">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-pen"></i>
            Editar Rol
        </h2>
        <a href="roles.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Regresar
        </a>
    </div>

    <?php if (isset($_SESSION['mensaje'])){ ?>
        <div class="alert alert-<?php echo $_SESSION['tipo']; ?>">
            <?php echo $_SESSION['mensaje']; ?>
        </div>
    <?php
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
    } ?>

    <div class="card">
        <div class="card-body">

            <form action="editarRol.php?id=<?php echo $id_rol; ?>" method="POST">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre del Rol</label>
                        <input type="text"
                               name="nombre"
                               class="form-control"
                               required
                               value="<?php echo $rol['nombre']; ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-control">
                            <option value="1" <?php if ($rol['estado'] == 1) echo "selected"; ?>>Activo</option>
                            <option value="0" <?php if ($rol['estado'] == 0) echo "selected"; ?>>Inactivo</option>
                        </select>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control"
                                  name="descripcion"
                                  rows="3"><?php echo $rol['descripcion']; ?></textarea>
                    </div>

                </div>

                <hr>

                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Actualizar Rol
                </button>

            </form>

        </div>
    </div>

</div>

<?php include "includes/footer.php"; ?>