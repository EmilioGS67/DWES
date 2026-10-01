<?php

//Ejercicio 1

$colores = ["Rojo", "Verde", "Azul", "Amarillo"];

foreach($colores as $color){
    echo $color . "<br>";
}

// Ejercicio 2

$nombres = ["Ana", "Luis", "Pedro", "Marta", "Juan"];

foreach($nombres as $saludo){
    echo "Hola " . $saludo . "<br>";
}

// Ejercicio 3

$notas = [7, 4, 9, 6, 3, 8];

foreach($notas as $nota){
    switch ($nota){
        case 1:
        case 2:
        case 3:
        case 4:
           echo $nota . " → Suspenso <br>";
        break;
        default:
            echo $nota . " → Aprobado <br>";
        break;
    }
}
?>