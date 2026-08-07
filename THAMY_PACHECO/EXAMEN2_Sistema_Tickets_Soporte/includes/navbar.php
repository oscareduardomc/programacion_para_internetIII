<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <button class="btn btn-outline-primary me-3" id="btnMenu" type="button" title="Alternar Menú">
            <i class="fa-solid fa-bars"></i>
        </button>

        <span class="navbar-brand fw-bold text-primary d-none d-sm-inline-block">
            Sistema de Tickets de Soporte
        </span>

        <div class="ms-auto d-flex align-items-center">
            <span class="me-3 d-none d-md-inline-block">
                <i class="fa-solid fa-user me-1 text-secondary"></i>
                <strong><?php echo htmlspecialchars($_SESSION['nombre'] ?? 'Usuario'); ?></strong>
                <span class="badge <?php echo (($_SESSION['rol'] ?? '') === 'tecnico') ? 'bg-danger' : 'bg-primary'; ?> ms-1">
                    <?php echo ucfirst(htmlspecialchars($_SESSION['rol'] ?? 'usuario')); ?>
                </span>
            </span>

           
        </div>
    </div>
</nav>
