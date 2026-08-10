<?php



require "includes/session.php";
require "config/db.php";
$query = "
    SELECT u.id_usuario,
    u.nombre,
    u.usuario,
    u.correo,
    u.estado,
    u.fecha_creacion,
    r.nombre as rol
    FROM usuarios u
    INNER JOIN roles r
    ON u.id_rol = r.id_rol
    ORDER BY u.id_usuario DESC
    ";
$resultado = $conn->query($query);
include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";


?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-users"></i>
            Usuarios
        </h2>





        <a class="btn btn-primary" href="nuevoUsuario.php">
            <i class="fa-solid fa-user-plus"></i>
            Nuevo Usuario
        </a>
    </div>
<?php 
if (isset($_SESSION['mensaje'])){


 ?>
 <div class="alert alert-<?php echo $_SESSION['tipo']; ?>">
    <?php echo $_SESSION['mensaje']; ?>

 </div>
 <?php 
    unset($_SESSION['mensaje']);
    unset($_SESSION['tipo']);
}
 ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered table-striped datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($usuario = $resultado->fetch_assoc()) {  ?>
                            <tr>
                                <td>
                                    <?php echo $usuario['id_usuario']; ?>
                                </td>
                                <td>
                                    <?php echo $usuario['nombre']; ?>
                                </td>
                                <td>
                                    <?php echo $usuario['usuario']; ?>
                                </td>
                                <td>
                                    <?php echo $usuario['correo']; ?>
                                </td>
                                <td>
                                    <?php echo $usuario['rol']; ?>
                                </td>
                                <td>
                                    <?php
                                    if ($usuario['estado'] == 1) {
                                        echo '<span class="bagde bg-success"> Activo </span>';
                                    } else {
                                        echo '<span class="bagde bg-danger"> Inactivo </span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php echo $usuario['fecha_creacion']; ?>
                                </td>
                                <td>
                                   <?php if($usuario['estado']==1){ ?>

<a href="controllers/eliminarUsuario.php?id=<?php echo $usuario['id_usuario']; ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('¿Desea desactivar este usuario?')">

    <i class="fa-solid fa-user-slash"></i>

</a>

<?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include "includes/footer.php";
?>