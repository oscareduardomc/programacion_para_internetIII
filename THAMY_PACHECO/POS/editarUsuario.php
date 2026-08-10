<?php

require "includes/session.php";
require "config/db.php";


if (!isset($_GET['id'])) {

    header("Location: usuarios.php");
    exit;
}

$id_usuario = intval($_GET['id']);


// Obtener usuario

$query = "SELECT * FROM usuarios WHERE id_usuario = ?";

$stmt = $conn->prepare($query);

$stmt->bind_param("i", $id_usuario);

$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {

    header("Location: usuarios.php");
    exit;
}

$usuario = $resultado->fetch_assoc();


// Obtener roles

$queryRoles = "SELECT * FROM roles WHERE estado = 1 ORDER BY nombre";

$roles = $conn->query($queryRoles);


include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>


<div class="content">


    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>

            <i class="fa-solid fa-user-pen"></i>

            Editar Usuario

        </h2>

        <a href="usuarios.php" class="btn btn-secondary">

            <i class="fa-solid fa-arrow-left"></i>

            Regresar

        </a>

    </div>


    <div class="card">

        <div class="card-body">


            <form action="controllers/editarUsuario.php" method="POST">


                <input type="hidden"
                       name="id_usuario"
                       value="<?php echo $usuario['id_usuario']; ?>">


                <div class="row">


                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Nombre

                        </label>

                        <input type="text"
                               name="nombre"
                               class="form-control"
                               required
                               value="<?php echo $usuario['nombre']; ?>">

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Usuario

                        </label>

                        <input type="text"
                               name="usuario"
                               class="form-control"
                               required
                               value="<?php echo $usuario['usuario']; ?>">

                    </div>


                </div>


                <div class="row">


                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Correo

                        </label>

                        <input type="email"
                               name="correo"
                               class="form-control"
                               value="<?php echo $usuario['correo']; ?>">

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Nueva Contraseña

                        </label>

                        <input type="password"
                               name="password"
                               class="form-control">

                        <small class="text-muted">

                            Déjela vacía para mantener la contraseña actual.

                        </small>

                    </div>


                </div>


                <div class="row">


                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Rol

                        </label>

                        <select name="id_rol"
                                class="form-control select2"
                                required>

                            <?php while($rol = $roles->fetch_assoc()){ ?>

                                <option
                                    value="<?php echo $rol['id_rol']; ?>"

                                    <?php

                                    if($rol['id_rol']==$usuario['id_rol']){

                                        echo "selected";

                                    }

                                    ?>

                                >

                                    <?php echo $rol['nombre']; ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">

                            Estado

                        </label>

                        <select name="estado"
                                class="form-control">

                            <option value="1"
                            <?php if($usuario['estado']==1) echo "selected"; ?>>

                                Activo

                            </option>

                            <option value="0"
                            <?php if($usuario['estado']==0) echo "selected"; ?>>

                                Inactivo

                            </option>

                        </select>

                    </div>


                </div>


                <hr>


                <button type="submit"
                        class="btn btn-primary">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Actualizar Usuario

                </button>


            </form>

        </div>

    </div>


</div>


<?php

include "includes/footer.php";

?>