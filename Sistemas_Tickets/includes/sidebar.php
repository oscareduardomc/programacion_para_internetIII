<div class="sidebar">
    <div class="sidebar-header">
        <h4>
            Sistema de Tickets
        </h4>
    </div>

    <div class="usuario">
        <div class="avatar">
            <i class="fa-solid fa-user"></i>
        </div>
        <div>
            <strong><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></strong>
            <br>
            <small><?php echo htmlspecialchars($_SESSION['usuario_rol']); ?></small>
        </div>
    </div>

    <ul class="menu">
        <li>
            <a href="dashboard.php">
                <i class="fa-solid fa-gauge"></i>
                Dashboard
            </a>
        </li>

        <li class="titulo">GESTIÓN DE TICKETS</li>

        <li>
            <a href="tickets.php">
                <i class="fa-solid fa-list"></i>
                <?php echo $_SESSION['usuario_rol'] === 'tecnico' ? 'Todos los Tickets' : 'Mis Tickets'; ?>
            </a>
        </li>

        <?php if ($_SESSION['usuario_rol'] === 'usuario') { ?>  
            <li>
                <a href="crearTicket.php">
                    <i class="fa-solid fa-circle-plus"></i>
                    Nuevo Ticket
                </a>
            </li>
        <?php } ?>

        <li class="titulo">SESIÓN</li>

        <li>
            <a href="logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                Cerrar Sesión
            </a>
        </li>
    </ul>
</div>