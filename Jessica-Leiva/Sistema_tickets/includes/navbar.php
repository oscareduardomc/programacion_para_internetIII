<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">

    <div class="container-fluid">

        <button class="btn btn-outline-primary" id="btnMenu">

            <i class="fa-solid fa-bars"></i>

        </button>

        <div class="ms-auto d-flex align-items-center">

            <span class="me-3">

                <i class="fa-solid fa-user"></i>

                <?php echo $_SESSION['nombre']; ?>

            </span>

            <div class="dropdown">

                <button class="btn btn-light dropdown-toggle"
                        type="button"
                        data-bs-toggle="dropdown">

                    <i class="fa-solid fa-circle-user"></i>

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li><hr class="dropdown-divider"></li>

                    <li>

                        <a class="dropdown-item text-danger" href="login.php">

                            <i class="fa-solid fa-right-from-bracket"></i>

                            Cerrar Sesión

                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </div>

</nav>