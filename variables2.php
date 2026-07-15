<?php       

$curso = "Programacion Internet III";
$periodo = "2";

// Forma 1: El punto(.) - Es el operador de concatenacion en PHP
echo "<p>Bienvenidos al curso de " . $curso . " del periodo " . $periodo . ".</p>";

// Forma 2: Interporlacion de comillas dobles - la mas facil
echo "<p>Bienvenidos al curso de $curso del periodo $periodo.</p>";



?>
