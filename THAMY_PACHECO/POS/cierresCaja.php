<?php

require "includes/session.php";
require "config/db.php";


// Asegurar que la columna 'diferencia' exista en la tabla aperturas_caja

$check_col = $conn->query("SHOW COLUMNS FROM aperturas_caja LIKE 'diferencia'");


if ($check_col && $check_col->num_rows == 0) {

    $conn->query("ALTER TABLE aperturas_caja ADD diferencia DECIMAL(12,2) DEFAULT 0 AFTER monto_final");

}




// Query para obtener el historial de cierres y aperturas de caja

$query = "

SELECT

a.id_apertura,

a.fecha_apertura,

a.fecha_cierre,

a.monto_inicial,

a.monto_final,

a.diferencia,

a.estado,

a.observacion,

c.nombre AS caja,

u.nombre AS usuario,

COALESCE(v.total_ventas, 0) AS total_ventas


FROM aperturas_caja a


INNER JOIN cajas c

ON a.id_caja = c.id_caja



INNER JOIN usuarios u

ON a.id_usuario = u.id_usuario



LEFT JOIN (

    SELECT id_apertura, SUM(total) AS total_ventas

    FROM ventas

    WHERE estado = 'ACTIVA'

    GROUP BY id_apertura

) v

ON a.id_apertura = v.id_apertura



ORDER BY a.id_apertura DESC

";


$resultado = $conn->query($query);


$cierres = [];

if ($resultado && $resultado->num_rows > 0) {

    while ($row = $resultado->fetch_assoc()) {

        $cierres[] = $row;

    }

}


include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>


<div class="content">


<div class="d-flex justify-content-between align-items-center mb-4">


<h2>

<i class="fa-solid fa-clock-rotate-left"></i>

Historial de Cierres de Caja

</h2>


<div>

<a href="aperturaCaja.php" class="btn btn-success me-2">

<i class="fa-solid fa-lock-open"></i>

Apertura de Caja

</a>

<a href="cerrarCaja.php" class="btn btn-danger">

<i class="fa-solid fa-lock"></i>

Cerrar Caja Active

</a>

</div>


</div>




<?php 

if (isset($_SESSION['mensaje'])){

?>

<div class="alert alert-<?php echo $_SESSION['tipo']; ?>">

<?php echo $_SESSION['mensaje']; ?>

</div>

<?php 

    unset($_SESSION['mensaje']);
    unset($_SESSION['tipo']);

}

?>




<div class="card">


<div class="card-body">


<div class="table-responsive">


<table class="table table-bordered table-striped datatable">


<thead>


<tr>


<th>
ID
</th>


<th>
Caja
</th>


<th>
Usuario
</th>


<th>
Fecha Apertura
</th>


<th>
Fecha Cierre
</th>


<th>
Monto Inicial
</th>


<th>
Total Ventas
</th>


<th>
Monto Final
</th>


<th>
Diferencia
</th>


<th>
Estado
</th>


<th>
Acciones
</th>


</tr>


</thead>




<tbody>


<?php 

if (!empty($cierres)) {

    foreach ($cierres as $cierre) { 

?>


<tr>


<td>

<?php echo $cierre['id_apertura']; ?>

</td>




<td>

<?php echo htmlspecialchars($cierre['caja']); ?>

</td>




<td>

<?php echo htmlspecialchars($cierre['usuario']); ?>

</td>




<td>

<?php echo $cierre['fecha_apertura']; ?>

</td>




<td>

<?php 

if ($cierre['fecha_cierre']) {

    echo $cierre['fecha_cierre'];

} else {

    echo '<span class="text-muted">En proceso</span>';

}

?>

</td>




<td>

L. <?php echo number_format($cierre['monto_inicial'], 2); ?>

</td>




<td>

L. <?php echo number_format($cierre['total_ventas'], 2); ?>

</td>




<td>

<?php 

if ($cierre['monto_final'] !== null) {

    echo 'L. ' . number_format($cierre['monto_final'], 2);

} else {

    echo '-';

}

?>

</td>




<td>

<?php 

if ($cierre['estado'] == 'CERRADA') {

    $dif = floatval($cierre['diferencia']);

    if ($dif == 0) {

        echo '<span class="badge bg-success">L. 0.00</span>';

    } else if ($dif > 0) {

        echo '<span class="badge bg-primary">+ L. ' . number_format($dif, 2) . '</span>';

    } else {

        echo '<span class="badge bg-danger">L. ' . number_format($dif, 2) . '</span>';

    }

} else {

    echo '-';

}

?>

</td>




<td>

<?php

if ($cierre['estado'] == "ABIERTA") {

    echo '<span class="badge bg-success">ABIERTA</span>';

} else {

    echo '<span class="badge bg-secondary">CERRADA</span>';

}

?>

</td>




<td>


<button type="button" 

class="btn btn-info btn-sm text-white" 

data-bs-toggle="modal" 

data-bs-target="#modalDetalle<?php echo $cierre['id_apertura']; ?>"

title="Ver Detalle">


<i class="fa-solid fa-eye"></i>


</button>




<?php if ($cierre['estado'] == 'ABIERTA') { ?>


<a href="cerrarCaja.php" 

class="btn btn-warning btn-sm" 

title="Cerrar Caja">


<i class="fa-solid fa-lock"></i>


</a>


<?php } ?>


</td>


</tr>


<?php 

    }

} 

?>


</tbody>


</table>


</div>


</div>


</div>


</div>




<!-- MODALES DE DETALLE (FUERA DE LA TABLA) -->

<?php 

if (!empty($cierres)) {

    foreach ($cierres as $cierre) { 

?>


<div class="modal fade" 

id="modalDetalle<?php echo $cierre['id_apertura']; ?>" 

tabindex="-1" 

aria-labelledby="labelModal<?php echo $cierre['id_apertura']; ?>" 

aria-hidden="true">


<div class="modal-dialog modal-lg">


<div class="modal-content">


<div class="modal-header bg-primary text-white">


<h5 class="modal-title" id="labelModal<?php echo $cierre['id_apertura']; ?>">

<i class="fa-solid fa-file-lines me-2"></i>

Detalle de Cierre de Caja #<?php echo $cierre['id_apertura']; ?>

</h5>


<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>


</div>




<div class="modal-body">


<div class="row mb-3">


<div class="col-md-6">

<p class="mb-1"><strong>Caja:</strong> <?php echo htmlspecialchars($cierre['caja']); ?></p>

<p class="mb-1"><strong>Usuario:</strong> <?php echo htmlspecialchars($cierre['usuario']); ?></p>

<p class="mb-1"><strong>Estado:</strong> 

<?php 

if ($cierre['estado'] == 'ABIERTA') {

    echo '<span class="badge bg-success">ABIERTA</span>';

} else {

    echo '<span class="badge bg-secondary">CERRADA</span>';

}

?>

</p>

</div>




<div class="col-md-6">

<p class="mb-1"><strong>Apertura:</strong> <?php echo $cierre['fecha_apertura']; ?></p>

<p class="mb-1"><strong>Cierre:</strong> <?php echo $cierre['fecha_cierre'] ? $cierre['fecha_cierre'] : 'En proceso'; ?></p>

</div>


</div>




<hr>




<h6><i class="fa-solid fa-wallet me-1"></i> Resumen Financiero</h6>


<div class="row text-center my-3">


<div class="col-md-3">

<div class="p-2 border rounded bg-light">

<small class="text-muted d-block">Monto Inicial</small>

<strong>L. <?php echo number_format($cierre['monto_inicial'], 2); ?></strong>

</div>

</div>




<div class="col-md-3">

<div class="p-2 border rounded bg-light">

<small class="text-muted d-block">Total Ventas</small>

<strong>L. <?php echo number_format($cierre['total_ventas'], 2); ?></strong>

</div>

</div>




<div class="col-md-3">

<div class="p-2 border rounded bg-light">

<small class="text-muted d-block">Efectivo Contado</small>

<strong>

<?php 

if ($cierre['monto_final'] !== null) {

    echo 'L. ' . number_format($cierre['monto_final'], 2);

} else {

    echo 'Pendiente';

}

?>

</strong>

</div>

</div>




<div class="col-md-3">

<div class="p-2 border rounded bg-light">

<small class="text-muted d-block">Diferencia</small>

<strong>

<?php 

if ($cierre['estado'] == 'CERRADA') {

    $dif = floatval($cierre['diferencia']);

    if ($dif == 0) {

        echo '<span class="text-success">L. 0.00</span>';

    } else if ($dif > 0) {

        echo '<span class="text-primary">+ L. ' . number_format($dif, 2) . '</span>';

    } else {

        echo '<span class="text-danger">L. ' . number_format($dif, 2) . '</span>';

    }

} else {

    echo '-';

}

?>

</strong>

</div>

</div>


</div>




<hr>




<h6><i class="fa-solid fa-credit-card me-1"></i> Ventas por Método de Pago</h6>


<?php

$id_ap = $cierre['id_apertura'];

$query_pagos = "

SELECT 

fp.forma_pago,

COALESCE(SUM(v.total), 0) AS total

FROM formas_pago fp

LEFT JOIN ventas v 

ON v.id_forma_pago = fp.id_forma_pago 

AND v.id_apertura = {$id_ap} 

AND v.estado = 'ACTIVA'

GROUP BY fp.id_forma_pago, fp.forma_pago

";


$res_pagos = $conn->query($query_pagos);

?>




<table class="table table-sm table-bordered mt-2">


<thead class="table-light text-dark">

<tr>

<th>Forma de Pago</th>

<th class="text-end">Total</th>

</tr>

</thead>




<tbody>

<?php 

if ($res_pagos && $res_pagos->num_rows > 0) {

    while($fp = $res_pagos->fetch_assoc()) { 

?>

<tr>

<td><?php echo htmlspecialchars($fp['forma_pago']); ?></td>

<td class="text-end">L. <?php echo number_format($fp['total'], 2); ?></td>

</tr>

<?php 

    }

} 

?>

</tbody>


</table>




<?php if (!empty($cierre['observacion'])) { ?>


<div class="mt-3">

<strong>Observaciones:</strong>

<p class="border p-2 rounded bg-light text-muted mb-0">

<?php echo nl2br(htmlspecialchars($cierre['observacion'])); ?>

</p>

</div>


<?php } ?>


</div>




<div class="modal-footer">


<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

Cerrar

</button>


</div>


</div>


</div>


</div>


<?php 

    }

} 

?>




<?php

include "includes/footer.php";

?>
