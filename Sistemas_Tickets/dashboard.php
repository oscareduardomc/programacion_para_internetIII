<?php
require "includes/session.php";
include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";
?>

<div class="content">
    <div class="card">
        <div class="card-body p-4">
            <h2>
                <i class="fa-solid fa-house"></i>
                Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>
            </h2>
            <p class="text-muted">
                Has iniciado sesión como
                <strong><?php echo htmlspecialchars($_SESSION['usuario_rol']); ?></strong>.
            </p>

            <?php if ($_SESSION['usuario_rol'] === 'usuario') { ?>
                <p>Puedes crear solicitudes y consultar únicamente tus propios tickets.</p>
                <a href="crearTicket.php" class="btn btn-primary">Crear solicitud</a>
                <a href="tickets.php" class="btn btn-outline-primary">Ver mis tickets</a>
            <?php } else { ?>
                <p>Puedes ver todos los tickets registrados y actualizar su estado.</p>
                <a href="tickets.php" class="btn btn-primary">Ver todos los tickets</a>
            <?php } ?>  
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>