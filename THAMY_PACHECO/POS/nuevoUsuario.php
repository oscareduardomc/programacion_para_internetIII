<?php



require "includes/session.php";
require "config/db.php";

$query_roles = "SELECT * FROM roles where estado = 1 ORDER BY nombre ASC";
$roles = $conn->query($query_roles);
include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";


?>
<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-user-plus"></i>
            Nuevo Usuario
        </h2>
        <a href="usuarios.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Regresar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="controllers/guardarUsuario.php" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Ingrese Nombre completo" require>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">usuario</label>
                        <input type="text" class="form-control" name="usuario" placeholder="Usuario para iniciar sesion" require>
                    </div>
                </div>
<div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Correo</label>
                        <input type="email" class="form-control" name="correo" placeholder="correo@ejemplo.com" >
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Clave</label>
                        <input type="password" class="form-control" name="password"  require>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Rol</label>
                        <select name="id_rol" class="form-control select2" require>
                           <option value="">Seleccione una opcion</option>
                           <?php while($rol = $roles->fetch_assoc()){ ?>
                           <option value="<?php echo $rol['id_rol']; ?>">
                                <?php echo $rol['nombre']; ?>


                           </option>
                           <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label">Estado</label>
                        <select name="estado" class="form-control" >
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i>
                    Guardar Usuario
                </button>
            </form>
        </div>
    </div>
</div>

<?php 
include "includes/footer.php";
?>