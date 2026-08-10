<div class="sidebar">

    <div class="sidebar-header">

        <h4>
            <i class="fa-solid fa-cash-register"></i>
            Punto de Venta
        </h4>

    </div>

    <div class="usuario">

        <div class="avatar">

            <i class="fa-solid fa-user"></i>

        </div>

        <div>

            <strong><?php echo $_SESSION['nombre']; ?></strong>

            <br>

            <small><?php echo $_SESSION['nombre_rol']; ?></small>

        </div>

    </div>

    <ul class="menu">

        <li>
            <a href="dashboard.php">
                <i class="fa-solid fa-gauge"></i>
                Dashboard
            </a>
        </li>

        <li class="titulo">
            ADMINISTRACIÓN
        </li>

        <li>
            <a href="usuarios.php">
                <i class="fa-solid fa-users"></i>
                Usuarios
            </a>
        </li>

        <li>
            <a href="roles.php">
                <i class="fa-solid fa-user-shield"></i>
                Roles
            </a>
        </li>

        <li class="titulo">
            INVENTARIO
        </li>

        <li>
            <a href="categorias.php">
                <i class="fa-solid fa-tags"></i>
                Categorías
            </a>
        </li>

        <li>
            <a href="productos.php">
                <i class="fa-solid fa-box"></i>
                Productos
            </a>
        </li>

        <li>
            <a href="clientes.php">
                <i class="fa-solid fa-address-book"></i>
                Clientes
            </a>
        </li>

        <li>
            <a href="proveedores.php">
                <i class="fa-solid fa-truck"></i>
                Proveedores
            </a>
        </li>

        <li class="titulo">
            VENTAS
        </li>

        <li>
            <a href="ventas.php">
                <i class="fa-solid fa-cart-shopping"></i>
                Nueva Venta
            </a>
        </li>

        <li>
            <a href="facturas.php">
                <i class="fa-solid fa-file-invoice"></i>
                Facturas
            </a>
        </li>

        <li class="titulo">
            CAJA
        </li>

        <li>
            <a href="aperturaCaja.php">
                <i class="fa-solid fa-lock-open"></i>
                Apertura de Caja
            </a>
        </li>

        <li>
            <a href="cierresCaja.php">
                <i class="fa-solid fa-lock"></i>
                Cierre de Caja
            </a>
        </li>

        <li>
            <a href="movimientosCaja.php">
                <i class="fa-solid fa-money-bill-transfer"></i>
                Movimientos
            </a>
        </li>

        <li class="titulo">
            REPORTES
        </li>

        <li>
            <a href="reportes.php">
                <i class="fa-solid fa-chart-column"></i>
                Reportes
            </a>
        </li>

        <li class="titulo">
            CONFIGURACIÓN
        </li>

        <li>
            <a href="empresa.php">
                <i class="fa-solid fa-building"></i>
                Empresa
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