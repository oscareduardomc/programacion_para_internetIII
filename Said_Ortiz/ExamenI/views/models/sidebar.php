<div class="bg-dark text-white p-3" style="min-width: 250px; min-height:100vh;">
    <h4 class="text-center mb-4">Taller Mecánico</h4>
    <hr class="bg-light">
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-2">
            <a href="index.php" class="nav-link text-white <?= (!isset($_GET['action']) || $_GET['action'] == 'inicio' || $_GET['action'] == 'crear' || $_GET['action'] == 'editar') ? 'bg-secondary' : '' ?>">
                <i class="bi bi-tools me-2"></i>Repuestos
            </a>
        </li>
        <li class="nav-item mb-2">
            <a href="index.php?action=categorias" class="nav-link text-white <?= (isset($_GET['action']) && ($_GET['action'] == 'categorias' || $_GET['action'] == 'crearCategoria' || $_GET['action'] == 'editarCategoria')) ? 'bg-secondary' : '' ?>">
                <i class="bi bi-tags me-2"></i>Categorías
            </a>
        </li>
    </ul>
</div>
<div class="w-100 d-flex flex-column justify-content-between">
    <div class="container-fluid p-4">
