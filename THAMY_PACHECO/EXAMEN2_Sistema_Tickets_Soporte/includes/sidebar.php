<div class="sidebar">
    <div class="sidebar-header">
        <h4>
            Sistema de Tickets de Soporte
        </h4>
    </div>

    <div class="usuario">
        <div class="avatar">
            <i class="fa-solid fa-user"></i>
        </div>
        <div>
            <strong><?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Usuario'); ?></strong>
            <br>
            <small class="badge <?php echo (($_SESSION['rol'] ?? '') === 'tecnico') ? 'bg-danger' : 'bg-primary'; ?>">
                <i class="fa-solid <?php echo (($_SESSION['rol'] ?? '') === 'tecnico') ? 'fa-user-gear' : 'fa-user'; ?> me-1"></i>
                <?php echo ucfirst(htmlspecialchars($_SESSION['rol'] ?? 'usuario')); ?>
            </small>
        </div>
    </div>

    <ul class="menu">
        <li class="titulo">Navegación Principal</li>
        
        <li>
            <a href="dashboard.php">
                <i class="fa-solid fa-gauge"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <?php if (($_SESSION['rol'] ?? '') === 'tecnico') { ?>
            <li class="titulo">Administración</li>
            <li>
                <a href="usuarios.php">
                    <i class="fa-solid fa-users"></i>
                    <span>Usuarios</span>
                </a>
            </li>
            <li>
                <a href="nuevoUsuario.php">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Nuevo Usuario</span>
                </a>
            </li>
        <?php } ?>

        <li class="titulo">Gestión de Incidencias</li>

        <li>
            <a href="tickets.php">
                <i class="fa-solid fa-ticket-simple"></i>
                <span>
                    <?php echo (($_SESSION['rol'] ?? '') === 'tecnico') ? 'Todos los Tickets' : 'Mis Tickets'; ?>
                </span>
            </a>
        </li>

        <li>
            <a href="nuevoTicket.php">
                <i class="fa-solid fa-circle-plus"></i>
                <span>Nuevo Ticket</span>
            </a>
        </li>

        <li class="titulo">Cuenta</li>

        <li>
            <a href="logout.php" class="text-danger">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Cerrar Sesión</span>
            </a>
        </li>
    </ul>
</div>
