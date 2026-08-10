<?php

require "includes/session.php";
require "config/db.php";



$query = "

SELECT

v.id_venta,

v.numero_factura,

v.fecha,

v.total,

v.estado,

u.nombre AS usuario,

c.nombre AS cliente,

fp.forma_pago


FROM ventas v


INNER JOIN usuarios u

ON v.id_usuario = u.id_usuario



INNER JOIN formas_pago fp

ON v.id_forma_pago = fp.id_forma_pago



LEFT JOIN clientes c

ON v.id_cliente = c.id_cliente



ORDER BY v.id_venta DESC


";



$resultado = $conn->query($query);



include "includes/header.php";
include "includes/sidebar.php";
include "includes/navbar.php";

?>


<div class="content">


<div class="d-flex justify-content-between align-items-center mb-4">


<h2>

<i class="fa-solid fa-file-invoice"></i>

Facturas

</h2>


</div>




<div class="card">


<div class="card-body">



<div class="table-responsive">


<table class="table table-bordered table-striped datatable">


<thead>


<tr>


<th>
Factura
</th>


<th>
Fecha
</th>


<th>
Cliente
</th>


<th>
Usuario
</th>


<th>
Forma Pago
</th>


<th>
Total
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



<?php while($factura=$resultado->fetch_assoc()){ ?>



<tr>



<td>

<?php echo $factura['numero_factura']; ?>

</td>



<td>

<?php echo $factura['fecha']; ?>

</td>



<td>

<?php

echo $factura['cliente'] 
?? 
"Consumidor Final";

?>

</td>



<td>

<?php echo $factura['usuario']; ?>

</td>



<td>

<?php echo $factura['forma_pago']; ?>

</td>



<td>

L.

<?php echo number_format($factura['total'],2); ?>

</td>




<td>


<?php

if($factura['estado']=="ACTIVA"){


echo '

<span class="badge bg-success">

ACTIVA

</span>

';


}else{


echo '

<span class="badge bg-danger">

ANULADA

</span>

';


}


?>



</td>




<td>



<a href="detalleFactura.php?id=<?php echo $factura['id_venta']; ?>"

class="btn btn-info btn-sm">


<i class="fa-solid fa-eye"></i>


</a>





<a href="imprimirFactura.php?id=<?php echo $factura['id_venta']; ?>"

target="_blank"

class="btn btn-primary btn-sm">


<i class="fa-solid fa-print"></i>


</a>




</td>



</tr>



<?php } ?>



</tbody>



</table>



</div>



</div>



</div>



</div>



<?php

include "includes/footer.php";

?>