<?php

//Ejercicio 1

$edad = 20;

if ($edad > 18) {
    echo "Mayor de edad. <br>";
}

if ($edad < 18) {
    echo "Menor de edad. <br>";
}

// Ejercicio 2

$numero = -5;

if ($numero > 0){
    echo"Positivo <br>";
} else if($numero < 0){
    echo"Negativo <br>";
} else {
    echo"El número es 0 <br>";
}

// Ejercicio 3

$password = "1234";

if ($password == "1234"){
    echo"Contraseña correcta <br>";
} else {
    echo"Contraseña incorrecta <br>";
}
?>