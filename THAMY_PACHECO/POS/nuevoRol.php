<?php

require "includes/session.php";
require "config/db.php";



if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $nombre      = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $estado      = intval($_POST['estado']);


    if (
        empty($nombre)
    ) {

        $_SESSION['mensaje'] = "El nombre del rol es obligatorio.";
        $_SESSION['tipo'] = "danger";

        header("Location: nuevoRol.php");
        exit;
    }


    // Verificar rol existente

    $consulta = "
        SELECT id_rol 
        FROM roles 
        WHERE nombre = ?
    ";

    $stmt = $conn->prepare($consulta);

    $stmt->bind_param("s", $nombre);

    $stmt->execute();

    $resultado = $stmt->get_result();


    if ($resultado->num_rows > 0) {

        $_SESSION['mensaje'] = "Ya existe un rol con ese nombre.";
        $_SESSION['tipo'] = "warning";

        header("Location: nuevoRol.php");
        exit;
    }


    // Insertar rol

    $query = "

        INSERT INTO roles
        (
            nombre,
            descripcion,
            estado
        )

        VALUES
        (
            ?,
            ?,
            ?
        )

    ";

    $stmt = $conn->prepare($query);

    $stmt->bind_param("ssi", $nombre, $descripcion, $estado);


    if ($stmt->execute()) {

        $_SESSION['mensaje'] = "Rol registrado correctamente.";
        $_SESSION['tipo'] = "success";

        header("Location: roles.php");
        exit;
    } else {

        $_SESSION['mensaje'] = "Error al guardar el rol.";
        $_SESSION['tipo'] = "danger";

        header("Location: nuevoRol.php");
        exit;
    }
}


include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>
<div class="content">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-plus"></i>
            Nuevo Rol
        </h2>
        <a href="roles.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Regresar
        </a>
    </div>

    <!-- Mensajes de sesión -->
    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?php echo $_SESSION['tipo']; ?>">
            <?php echo $_SESSION['mensaje']; ?>
        </div>
        <?php
            unset($_SESSION['mensaje']);
            unset($_SESSION['tipo']);
        ?>
    <?php } ?>

    <!-- Formulario -->
    <div class="card">
        <div class="card-body">
            <form action="nuevoRol.php" method="POST">
                <div class="row">
                    <!-- Nombre del Rol -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre del Rol</label>
                        <input type="text"
                               class="form-control"
                               name="nombre"
                               placeholder="Ej. Supervisor"
                               required>
                    </div>

                    <!-- Estado -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-control">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control"
                                  name="descripcion"
                                  rows="3"
                                  placeholder="Describe las funciones de este rol"></textarea>
                    </div>
                </div>

                <hr>

                <!-- Botón Guardar -->
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i>
                    Guardar Rol
                </button>
            </form>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
