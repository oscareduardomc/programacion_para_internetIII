<?php
require "includes/session.php";
require "config/db.php";

$rol = $_SESSION['rol'];
$id_usuario = $_SESSION['id_usuario'];

if ($rol === 'tecnico') {
  $query = "SELECT t.id,
           t.id_usuario,
           u.nombre,
           t.titulo,
           t.descripcion,
           t.prioridad,
           t.estado,
           t.fecha_creacion
    FROM tickets t
    INNER JOIN usuarios u
      ON t.id_usuario = u.id_usuario
    ORDER BY t.id DESC
  ";
} else {
  $query = "SELECT t.id,
           t.id_usuario,
           u.nombre,
           t.titulo,
           t.descripcion,
           t.prioridad,
           t.estado,
           t.fecha_creacion
    FROM tickets t
    INNER JOIN usuarios u
      ON t.id_usuario = u.id_usuario
    WHERE t.id_usuario = ?
    ORDER BY t.id DESC
  ";
}

if ($rol === 'tecnico') {
  $resultado = $conn->query($query);
} else {
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $id_usuario);
  $stmt->execute();
  $resultado = $stmt->get_result();
}

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";
?>

 <link href="assets/css/prioridad.css" rel="stylesheet">
    
<div class="content">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
      <i class="fa-solid fa-ticket"></i>
      Tickets
    </h2>

    <div>

      <a class="btn btn-outline-danger" href="controllers/logout.php">
        <i class="fa-solid fa-right-from-bracket"></i>
        Cerrar sesión
      </a>
    </div>
  </div>


  <?php
  if (isset($_SESSION['mensaje'])) {
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
              <th>Título</th>
              <th>Usuario</th>
              <th>Prioridad</th>
              <th>Estado</th>
              <th>Fecha de creación</th>
              <th>Acciones</th>
            </tr>
          </thead>

          <tbody>
            <?php while ($ticket = $resultado->fetch_assoc()) { ?>

              <?php
                $estado = "";
                if ($ticket['prioridad'] === 'Alta') {
                  $estado = "prioridad-alta";
                }
              ?>

              <tr class="<?php echo $estado; ?>">
                <td><?php echo $ticket['id']; ?></td>

                <td><?php echo $ticket['titulo']; ?></td>

                <td><?php echo $ticket['id_usuario']; ?> - <?php echo $ticket['nombre']; ?></td>

                <td>
                  <?php echo $ticket['prioridad']; ?>
                </td>

                <td>
                  <?php
                    if ($ticket['estado'] === 'Pendiente') {
                      echo '<span class="badge badge-pendiente">Pendiente</span>';
                    } elseif ($ticket['estado'] === 'Resuelto') {
                      echo '<span class="badge badge-resuelto">Resuelto</span>';
                    } else {
                      echo '<span class="badge badge-en-proceso">En Proceso</span>';
                    }
                  ?>
                </td>

                <td><?php echo $ticket['fecha_creacion']; ?></td>

                <td>
                  <?php if ($rol === 'tecnico') { ?>
                    <form method="POST" action="controllers/cambiarEstadoTicket.php">
                      <input type="hidden" name="id_ticket" value="<?php echo $ticket['id']; ?>">

                      <select name="nuevo_estado" class="form-select form-select-sm mb-2" required>
                        <option value="Pendiente" <?php echo ($ticket['estado']==='Pendiente')?'selected':''; ?>>Pendiente</option>
                        <option value="En Proceso" <?php echo ($ticket['estado']==='En Proceso')?'selected':''; ?>>En Proceso</option>
                        <option value="Resuelto" <?php echo ($ticket['estado']==='Resuelto')?'selected':''; ?>>Resuelto</option>
                      </select>

                      <button type="submit" class="btn btn-primary btn-sm">Cambiar</button>
                    </form>
                  <?php } else { ?>
                    <span class="text-muted">Solo lectura</span>
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

<?php include "includes/footer.php"; ?>
