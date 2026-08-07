<?php

require "includes/session.php";
require "config/db.php";

if ($_SESSION['rol'] === 'tecnico'){

    $query = "
        SELECT t.id,
        t.titulo,
        t.descripcion,
        t.departamento,
        t.prioridad,
        t.estado,
        t.fecha_creacion,
        u.nombre as nombre_usuario
        FROM tickets t
        INNER JOIN usuarios u
        ON t.id_usuario = u.id
        ORDER BY t.fecha_creacion DESC
    ";
    $resultado = $conn->query($query);

}else{

    $query = "
        SELECT t.id,
        t.titulo,
        t.descripcion,
        t.departamento,
        t.prioridad,
        t.estado,
        t.fecha_creacion
        FROM tickets t
        WHERE t.id_usuario = ?
        ORDER BY t.fecha_creacion DESC
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_SESSION['id_usuario']);
    $stmt->execute();
    $resultado = $stmt->get_result();

}

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>

<div class="content">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-ticket"></i>
            <?php echo $_SESSION['rol'] === 'tecnico' ? 'Todos los Tickets' : 'Mis Tickets'; ?>
        </h2>
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

                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <?php if ($_SESSION['rol'] === 'tecnico'){ ?>
                            <th>Usuario</th>
                            <?php } ?>
                            <th>Titulo</th>
                            <th>Departamento</th>
                            <th>Prioridad</th>
                            <th>Estado</th>
                            <th>Fecha de Creacion</th>
                            <?php if ($_SESSION['rol'] === 'tecnico'){ ?>
                            <th>Cambiar Estado</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($ticket = $resultado->fetch_assoc()) { ?>

                            <?php
                                $claseFila = ($ticket['prioridad'] === 'Alta') ? 'fila-alta' : '';
                            ?>

                            <tr class="<?php echo $claseFila; ?>">
                                <td>
                                    <?php echo $ticket['id']; ?>
                                </td>

                                <?php if ($_SESSION['rol'] === 'tecnico'){ ?>
                                <td>
                                    <?php echo $ticket['nombre_usuario']; ?>
                                </td>
                                <?php } ?>

                                <td>
                                    <?php echo $ticket['titulo']; ?>
                                    <br>
                                    <small class="text-muted">
                                        <?php echo $ticket['descripcion']; ?>
                                    </small>
                                </td>

                                <td>
                                    <?php echo $ticket['departamento']; ?>
                                </td>

                                <td>
                                    <?php
                                    if ($ticket['prioridad'] === 'Alta'){
                                        echo '<span class="badge badge-prioridad-alta">Alta</span>';
                                    }elseif ($ticket['prioridad'] === 'Media'){
                                        echo '<span class="badge badge-prioridad-media">Media</span>';
                                    }else{
                                        echo '<span class="badge badge-prioridad-baja">Baja</span>';
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    if ($ticket['estado'] === 'Pendiente'){
                                        echo '<span class="badge badge-pendiente">Pendiente</span>';
                                    }elseif ($ticket['estado'] === 'En Proceso'){
                                        echo '<span class="badge badge-proceso">En Proceso</span>';
                                    }else{
                                        echo '<span class="badge badge-resuelto">Resuelto</span>';
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?php echo $ticket['fecha_creacion']; ?>
                                </td>

                                <?php if ($_SESSION['rol'] === 'tecnico'){ ?>
                                <td>
                                    <form action="controllers/cambiarEstado.php" method="POST" class="d-flex gap-1">
                                        <input type="hidden" name="id_ticket" value="<?php echo $ticket['id']; ?>">
                                        <select name="estado" class="form-select form-select-sm">
                                            <option value="Pendiente" <?php echo $ticket['estado'] === 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                            <option value="En Proceso" <?php echo $ticket['estado'] === 'En Proceso' ? 'selected' : ''; ?>>En Proceso</option>
                                            <option value="Resuelto" <?php echo $ticket['estado'] === 'Resuelto' ? 'selected' : ''; ?>>Resuelto</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>
                                </td>
                                <?php } ?>

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
