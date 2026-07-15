<?php
$mensajes = [
    'guardado' => ['success', 'Proyecto guardado correctamente.'],
    'actualizado' => ['success', 'Proyecto actualizado correctamente.'],
    'soft_delete' => ['warning', 'Proyecto marcado como inactivo. Ya no aparece en la vista principal.'],
    'hard_delete' => ['danger', 'Proyecto eliminado permanentemente de la base de datos.'],
    'error_validacion' => ['danger', 'Datos inválidos. Revise que no haya campos vacíos, que el cliente sea válido, el presupuesto sea mayor a 0 y la fecha sea posterior a hoy.'],
    'error_id' => ['danger', 'ID inválido. No se pudo procesar la solicitud.']
];

if (isset($_GET['msg']) && isset($mensajes[$_GET['msg']])):
    [$tipo, $texto] = $mensajes[$_GET['msg']];
?>
<div class="alert alert-<?php echo $tipo; ?> alert-dismissible fade show" role="alert">
    <?php echo $texto; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
</div>
<?php endif; ?>