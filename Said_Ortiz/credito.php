<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EJERCICIO TRABAJO EN CLASE</title>
    <style>
        body{
            font-family: Arial, sans-serif;
        margin: 30px;
        }
        .ALERTA{
            background-color: #ffcccc;
            color: #00cc07;
            padding: 10px;
            border: 1px solid #cc0000;
            margin-bottom: 20px;
        }
        .NORMAL{
            background-color: #ccffcc;
            color: #fa0259;
            padding: 10px;
            border: 1px solid #061306;
            margin-bottom: 20px;
        }
        </style>
</head>
<body>
    
<?php
$MONTO_SOLICITADO=850000;
$INGRESO_MENSUALES=45000;


IF($INGRESO_MENSUALES*10>=$MONTO_SOLICITADO){
    $MENSAJE="SU CRÉDITO A SIDO APROBADO";
    $CLASES="NORMAL";

}ELSE{
$MENSAJE="SU CRÉDITO A SIDO RECHAZADO";
$CLASES="ALERTA";
}

?>
<div class="<?php echo $CLASES; ?>">
        <P><strong>ESTADO:</strong> <?php echo $MENSAJE; ?></P>
    </div>

<H3>DETALLE DEL CRÉDITO</H3>
<UL>
    <LI><STRong>EL MONTO SOLICITADO ES: </STRong> L.<?php echo number_format($MONTO_SOLICITADO,2) ?></LI>
    <LI><STRong>EL INGRESO MENSUAL ES DE: </STRong>L.<?php echo number_format($INGRESO_MENSUALES,2) ?></LI>
</UL>

</body>
</html>
