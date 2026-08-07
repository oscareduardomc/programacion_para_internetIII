<div class="sidebar">
    <div class="sidebar-header">
        <h4>
            <i class="fa-solid fa-ticket"></i>
            Soporte Técnico
        </h4>
    </div>

    <div class="usuario">
        <div class="avatar">
            <i class="fa-solid fa-user"></i>
        </div>

        <div>
            <strong><?php echo htmlspecialchars($_SESSION['nombre']); ?></strong>
            <br>
            <small><?php echo htmlspecialchars(ucfirst($_SESSION['rol'])); ?></small>
        </div>
    </div>

    <ul class="menu">
        <li>
            <a href="dashboard.php">
                <i class="fa-solid fa-table-list"></i>
                Tickets
            </a>
        </li>

        <?php if (($_SESSION['rol'] ?? '') === 'usuario'): ?>
            <li>
                <a href="nuevoTicket.php">
                    <i class="fa-solid fa-plus"></i>
                    Nuevo Ticket
                </a>
            </li>
        <?php endif; ?>

        <li>
            <a href="logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                Cerrar Sesión
            </a>
        </li>
    </ul>
</div>
