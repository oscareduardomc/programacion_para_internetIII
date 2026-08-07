<?php



?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand">
            <i class="fa-solid fa-ticket"></i> Sistema de Tickets
        </span>

        <div class="d-flex">
            <span class="text-white me-3">
                <i class="fa-solid fa-user"></i>
                <?php echo $_SESSION['nombre']; ?>
                (<?php echo $_SESSION['rol']; ?>)
            </span>

            <a href="logout.php" class="btn btn-outline-light btn-sm">
                <i class="fa-solid fa-right-from-bracket"></i> Salir
            </a>
        </div>
    </div>
</nav>
