<div class="sidebar">

    <div class="sidebar-header">
        <h4>
            Soporte Técnico
        </h4>
    </div>

    <div class="usuario">
        <div class="avatar">
            <i class="fa-solid fa-user"></i>
        </div>
        <div>
            <strong><?php echo $_SESSION['nombre']; ?></strong>
            <br>
            <small><?php echo ucfirst($_SESSION['rol']); ?></small>
        </div>
    </div>

    <ul class="menu">

        <li>
            <a href="dashboard.php">
                Dashboard
            </a>
        </li>

        <?php if ($_SESSION['rol'] === 'usuario') { ?>

            <li class="titulo">MIS TICKETS</li>

            <li>
                <a href="tickets.php">
                    Mis Tickets
                </a>
            </li>

            <li>
                <a href="nuevoTicket.php">
                    Nuevo Ticket
                </a>
            </li>

        <?php } ?>

        <?php if ($_SESSION['rol'] === 'tecnico') { ?>

            <li class="titulo">GESTIÓN</li>

            <li>
                <a href="tickets.php">
                    Todos los Tickets
                </a>
            </li>

        <?php } ?>

        <li class="titulo">SESIÓN</li>

        <li>
            <a href="logout.php">
                Cerrar Sesión
            </a>
        </li>

    </ul>

</div>