<?php



?>
<div class="sidebar bg-white border-end" style="width: 220px; position: fixed; top: 56px; bottom: 0;">
    <ul class="list-group list-group-flush">

        <a href="tickets.php" class="list-group-item list-group-item-action">
            <i class="fa-solid fa-list"></i> Tickets
        </a>

        <?php if ($_SESSION['rol'] === 'usuario'): ?>
            <a href="nuevoTicket.php" class="list-group-item list-group-item-action">
                <i class="fa-solid fa-plus"></i> Nuevo Ticket
            </a>
        <?php endif; ?>

        <?php if ($_SESSION['rol'] === 'tecnico'): ?>
            <a href="reportes.php" class="list-group-item list-group-item-action">
                <i class="fa-solid fa-chart-line"></i> Reportes
            </a>
        <?php endif; ?>

    </ul>
</div>

<div class="content" style="margin-left: 230px; padding: 20px;">
