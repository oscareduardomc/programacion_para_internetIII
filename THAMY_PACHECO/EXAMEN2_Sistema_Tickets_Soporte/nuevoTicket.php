<?php
require "includes/session.php";
require "config/db.php";

include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";
?>

<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            <i class="fa-solid fa-circle-plus text-primary me-2"></i>Registrar Nuevo Ticket de Soporte
        </h2>
        
    </div>

    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?php echo $_SESSION['tipo'] ?? 'info'; ?> alert-dismissible fade show shadow-sm mb-4">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>
            <?php echo $_SESSION['mensaje']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php 
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo']);
        }
        ?>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        Formulario de Incidencia
                    </h5>
                </div>
                <div class="card-body p-4">
                    
                    <form action="controllers/guardarTicket.php" method="POST" id="formNuevoTicket">
                        
                        <div class="row">
                            
                            <div class="col-md-8 mb-3">
                                <label for="titulo" class="form-label fw-bold">Título de la Incidencia <span class="text-danger"></span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ej: Impresora no responde en oficina contabilidad" required autofocus>
                                </div>
                                <small class="text-muted">Describa brevemente el problema principal.</small>
                            </div>

                            
                            <div class="col-md-4 mb-3">
                                <label for="departamento" class="form-label fw-bold">Departamento <span class="text-danger"></span></label>
                                <div class="input-group">
                                    <select class="form-select" id="departamento" name="departamento" required>
                                        <option value="">-- Seleccione --</option>
                                        <option value="Administración">Administración</option>
                                        <option value="Contabilidad">Contabilidad</option>
                                        <option value="Recursos Humanos">Recursos Humanos</option>
                                        <option value="Sistemas / TI">Sistemas / TI</option>
                                        <option value="Ventas">Ventas</option>
                                        <option value="Operaciones">Operaciones</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="prioridad" class="form-label fw-bold">Prioridad Estimada <span class="text-danger"></span></label>
                                <div class="input-group">
                                    <select class="form-select" id="prioridad" name="prioridad" required>
                                        <option value="Baja">Baja </option>
                                        <option value="Media" selected>Media</option>
                                        <option value="Alta">Alta</option>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Solicitante</label>
                                <input type="text" class="form-control bg-light" value="<?php echo htmlspecialchars($_SESSION['nombre']); ?>" readonly>
                            </div>
                        </div>

                        
                        <div class="mb-4">
                            <label for="descripcion" class="form-label fw-bold">Descripción Detallada del Problema <span class="text-danger"></span></label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="5" placeholder="Proporcione detalles de lo sucedido, mensajes de error observados, equipo involucrado, etc." required></textarea>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="tickets.php" class="btn btn-secondary px-4">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">
                                Enviar Ticket
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>
