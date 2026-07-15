<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprendiendo Variables en PHP</title>
</head>
<<body>
    <h1>Perfil de Usuario (Uso de Variables)</h1>
    <?php
        // 1. Texto (String) - Va siempre entre comillas
        $nombreAlumno = "Marco Lara";

        // 2. Entero (Integer) - Numeros sin decimales
        $edad = 28;

        // 3. Decimal (Float - Double) - Usan PUNTO, no coma
        $promedioClase = 84.5;

        // 4. Booleano (Boolean) - Verdadero o Falso (true/false)
        $matriculado = true;
        
    ?>

 <p><strong>Nombre del estudiante:</strong><?php echo $nombreAlumno;?></p></body>
 <p><strong>Edad:</strong><?php echo $edad;?></p></body>
 <p><strong>Promedio de la clase:</strong><?php echo $promedioClase;?>%</p></body>
 <p><strong>Matriculado:</strong><?php echo $matriculado ? 'Sí' : 'No';?></p></body>

 </body>
</html>