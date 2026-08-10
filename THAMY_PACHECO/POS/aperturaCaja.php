<?php

require "includes/session.php";
require "config/db.php";


// Buscar apertura activa del usuario

$id_usuario = $_SESSION['id_usuario'];


$query = "

SELECT 
    a.*,
    c.nombre AS caja

FROM aperturas_caja a

INNER JOIN cajas c
ON a.id_caja = c.id_caja

WHERE a.id_usuario = ?

AND a.estado = 'ABIERTA'

LIMIT 1

";


$stmt = $conn->prepare($query);

$stmt->bind_param(
    "i",
    $id_usuario
);

$stmt->execute();

$resultado = $stmt->get_result();


$caja_abierta = null;


if($resultado->num_rows > 0){

    $caja_abierta = $resultado->fetch_assoc();

}



// Obtener cajas disponibles

$query_cajas = "

SELECT *
FROM cajas
WHERE estado = 1

ORDER BY nombre

";


$cajas = $conn->query($query_cajas);



include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>


<div class="content">


<div class="d-flex justify-content-between align-items-center mb-4">


<h2>

<i class="fa-solid fa-lock-open"></i>

Apertura de Caja

</h2>


</div>



<?php if($caja_abierta){ ?>


<div class="card border-success">


<div class="card-header bg-success text-white">

<i class="fa-solid fa-check-circle"></i>

Caja Abierta

</div>



<div class="card-body">


<div class="row">


<div class="col-md-4">

<h6>Caja</h6>

<h4>
<?php echo $caja_abierta['caja']; ?>
</h4>

</div>



<div class="col-md-4">

<h6>Monto Inicial</h6>

<h4>

L.
<?php echo number_format($caja_abierta['monto_inicial'],2); ?>

</h4>

</div>



<div class="col-md-4">

<h6>Fecha Apertura</h6>

<h4>

<?php echo $caja_abierta['fecha_apertura']; ?>

</h4>

</div>


</div>


<hr>


<a href="ventas.php"
class="btn btn-primary">

<i class="fa-solid fa-cart-shopping"></i>

Nueva Venta

</a>



<a href="cerrarCaja.php"
class="btn btn-danger">

<i class="fa-solid fa-lock"></i>

Cerrar Caja

</a>


</div>


</div>



<?php }else{ ?>



<div class="card">


<div class="card-body">


<form action="controllers/abrirCaja.php"
method="POST">


<div class="row">


<div class="col-md-6 mb-3">


<label class="form-label">

Caja

</label>


<select name="id_caja"
class="form-control"
required>


<option value="">

Seleccione caja

</option>


<?php while($caja=$cajas->fetch_assoc()){ ?>


<option value="<?php echo $caja['id_caja']; ?>">

<?php echo $caja['nombre']; ?>

</option>


<?php } ?>


</select>


</div>



<div class="col-md-6 mb-3">


<label class="form-label">

Monto Inicial

</label>


<input type="number"

step="0.01"

name="monto_inicial"

class="form-control"

required>


</div>


</div>



<div class="mb-3">


<label class="form-label">

Observación

</label>


<textarea name="observacion"

class="form-control"

rows="3"></textarea>


</div>



<button class="btn btn-success">


<i class="fa-solid fa-lock-open"></i>

Abrir Caja


</button>



</form>


</div>


</div>



<?php } ?>


</div>



<?php

include "includes/footer.php";

?>