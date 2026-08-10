<?php

require "includes/session.php";
require "config/db.php";


$id_usuario = $_SESSION['id_usuario'];


// Verificar caja abierta

$query = "

SELECT *

FROM aperturas_caja

WHERE id_usuario = ?

AND estado = 'ABIERTA'

LIMIT 1

";


$stmt = $conn->prepare($query);

$stmt->bind_param(
    "i",
    $id_usuario
);

$stmt->execute();

$resultado = $stmt->get_result();



if($resultado->num_rows == 0){


    $_SESSION['mensaje'] = 
    "Debe abrir caja antes de realizar ventas.";

    $_SESSION['tipo'] = "warning";


    header("Location: aperturaCaja.php");

    exit;

}



$apertura = $resultado->fetch_assoc();



// Clientes

$clientes = $conn->query("

SELECT *

FROM clientes

WHERE estado = 1

ORDER BY nombre

");



include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>



<div class="content">


<div class="d-flex justify-content-between mb-4">


<h2>

<i class="fa-solid fa-cart-shopping"></i>

Nueva Venta

</h2>


</div>



<div class="row">



<!-- AREA PRODUCTOS -->

<div class="col-md-8">


<div class="card">


<div class="card-body">



<h5>

Buscar Producto

</h5>


<input type="text"

id="buscarProducto"

class="form-control"

placeholder="Código o nombre del producto">

<div id="resultadoProductos"
class="list-group mt-2">
</div>

<br>



<table class="table table-bordered">


<thead>

<tr>

<th>
Producto
</th>


<th>
Cantidad
</th>


<th>
Precio
</th>


<th>
Total
</th>


<th>
</th>

</tr>


</thead>



<tbody id="detalleVenta">


</tbody>



</table>


</div>


</div>


</div>





<!-- RESUMEN -->

<div class="col-md-4">


<div class="card">


<div class="card-body">


<h5>

Datos Venta

</h5>



<label>

Cliente

</label>


<select class="form-control select2"
id="cliente">


<option value="">

Consumidor Final

</option>



<?php while($cliente=$clientes->fetch_assoc()){ ?>


<option value="<?php echo $cliente['id_cliente']; ?>">


<?php echo $cliente['nombre']; ?>


</option>


<?php } ?>


</select>



<br>



<label>

Subtotal

</label>


<input type="text"

id="subtotal"

class="form-control"

readonly>



<br>



<label>

Impuesto

</label>


<input type="text"

id="impuesto"

class="form-control"

readonly>



<br>



<label>

Descuento

</label>


<input type="number"

id="descuento"

class="form-control"

value="0">

<br>


<label>

Forma de Pago

</label>


<select id="forma_pago"

class="form-control">


<option value="1">

Efectivo

</option>


<option value="2">

Tarjeta

</option>


<option value="3">

Transferencia

</option>


<option value="4">

Crédito

</option>


</select>



<div id="datosPago"
style="display:none;">



<br>


<label>

Número de referencia

</label>


<input type="text"

id="referencia"

class="form-control"

placeholder="Número de operación">



<br>


<label>

Banco

</label>


<input type="text"

id="banco"

class="form-control"

placeholder="Nombre del banco">



</div>

<br>



<label>

TOTAL

</label>


<h2 class="text-success">

L.
<span id="total">0.00</span>

</h2>



<hr>



<button class="btn btn-success w-100"

id="guardarVenta">


<i class="fa-solid fa-check"></i>

Finalizar Venta


</button>


</div>


</div>



</div>



</div>



</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<script src="assets/js/ventas.js"></script>

<script src="assets/js/finalizarVenta.js"></script>

<script src="assets/js/pago.js"></script>

<?php

include "includes/footer.php";

?>