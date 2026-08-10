<?php

require "includes/session.php";
require "config/db.php";


$id_usuario = $_SESSION['id_usuario'];



// Buscar caja abierta

$query = "

SELECT

a.*,

c.nombre AS caja


FROM aperturas_caja a


INNER JOIN cajas c

ON a.id_caja = c.id_caja


WHERE a.id_usuario = ?

AND a.estado='ABIERTA'


LIMIT 1


";


$stmt=$conn->prepare($query);


$stmt->bind_param(
    "i",
    $id_usuario
);


$stmt->execute();


$apertura=$stmt->get_result()->fetch_assoc();



if(!$apertura){

    header("Location: aperturaCaja.php");

    exit;

}




$id_apertura=$apertura['id_apertura'];



// Totales de venta

$query="

SELECT

SUM(total) AS total_ventas


FROM ventas


WHERE id_apertura=?


AND estado='ACTIVA'


";


$stmt=$conn->prepare($query);


$stmt->bind_param(
    "i",
    $id_apertura
);


$stmt->execute();


$totales=$stmt->get_result()->fetch_assoc();



$totalVentas = $totales['total_ventas'] ?? 0;




// Ventas por forma de pago

$query="

SELECT

fp.forma_pago,

SUM(v.total) total


FROM ventas v


INNER JOIN formas_pago fp

ON v.id_forma_pago=fp.id_forma_pago


WHERE v.id_apertura=?


AND v.estado='ACTIVA'


GROUP BY fp.forma_pago


";


$stmt=$conn->prepare($query);


$stmt->bind_param(
    "i",
    $id_apertura
);


$stmt->execute();


$formas_pago=$stmt->get_result();



include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>


<div class="content">


<h2 class="mb-4">

<i class="fa-solid fa-lock"></i>

Cierre de Caja

</h2>




<div class="row">


<div class="col-md-6">


<div class="card">


<div class="card-body">


<h5>

Información Caja

</h5>


<p>

Caja:

<strong>

<?php echo $apertura['caja']; ?>

</strong>


</p>



<p>

Monto Inicial:

<strong>

L.
<?php echo number_format($apertura['monto_inicial'],2); ?>

</strong>


</p>



<p>

Total Ventas:

<strong>

L.
<?php echo number_format($totalVentas,2); ?>

</strong>


</p>



</div>


</div>


</div>





<div class="col-md-6">


<div class="card">


<div class="card-body">


<h5>

Ventas por método de pago

</h5>


<table class="table">


<thead>

<tr>

<th>

Forma Pago

</th>


<th>

Total

</th>


</tr>

</thead>


<tbody>


<?php while($forma=$formas_pago->fetch_assoc()){ ?>


<tr>


<td>

<?php echo $forma['forma_pago']; ?>

</td>


<td>

L.

<?php echo number_format($forma['total'],2); ?>

</td>


</tr>


<?php } ?>


</tbody>


</table>


</div>


</div>


</div>


</div>





<div class="card mt-3">


<div class="card-body">


<form action="controllers/cerrarCaja.php"
method="POST">


<input type="hidden"
name="id_apertura"
value="<?php echo $id_apertura; ?>">



<div class="row">


<div class="col-md-6">


<label class="form-label">

Efectivo contado

</label>


<input type="number"

step="0.01"

name="monto_final"

class="form-control"

placeholder="Monto inicial + ventas en efectivo"

required>

<small class="text-muted">Total de dinero físico en caja (Monto inicial + ventas en efectivo).</small>


</div>



<div class="col-md-6">


<label class="form-label">

Observación

</label>


<textarea name="observacion"

class="form-control"></textarea>


</div>


</div>


<br>



<button class="btn btn-danger">

<i class="fa-solid fa-lock"></i>

Cerrar Caja

</button>



</form>



</div>


</div>



</div>



<?php

include "includes/footer.php";

?>