<div class="sidebar">

    <div class="sidebar-header">

        <h4>
            <i class="fa-solid fa-headset"></i>
            Sistema de Tickets
        </h4>

    </div>

    

    <ul class="menu">

        <li>
            <a href="tickets.php">
                <i class="fa-solid fa-list"></i>
                <?php echo $_SESSION['rol'] === 'tecnico' ? 'Todos los Tickets' : 'Mis Tickets'; ?>
            </a>
        </li>

        <?php if ($_SESSION['rol'] === 'usuario'){ ?>
        <li>
            <a href="nuevoTicket.php">
                <i class="fa-solid fa-plus"></i>
                Nuevo Ticket
            </a>
        </li>
        <?php } ?>

        

        <li>
            <a href="logout.php" onclick="return confirm('¿Desea cerrar sesion?')">
                <i class="fa-solid fa-right-from-bracket"></i>
                Cerrar Sesion
            </a>
        </li>

    </ul>

</div>
