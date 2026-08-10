<div class="sidebar">

    <div class="sidebar-header">

        <h4>
           <i class="fa-solid fa-ticket"></i>
            Sistema Tickets de Soporte
        </h4>

    </div>

    <div class="usuario">

        <div class="avatar">

          <i class="fa-solid fa-ticket"></i>  <i class="fa-solid fa-user"></i>

        </div>

        <div>

            <strong><?php echo $_SESSION['nombre']; ?></strong>

            <br>

            <small><?php echo $_SESSION['rol']; ?></small>

        </div>

    </div>

    <ul class="menu">

        <li>
            <a href="tickets.php">
                <i class="fa-solid fa-ticket"></i>
               Tickets
            </a>
        </li>

        <li class="titulo">
            ADMINISTRACIÓN
        </li>

        <li>
            <a href="crearTickets.php">
               <i class="fa-solid fa-ticket"></i>
                Crear Tickets
            </a>
        </li>

   

        <li>
            <a href="logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                Cerrar Sesión
            </a>
        </li>

    </ul>

</div>