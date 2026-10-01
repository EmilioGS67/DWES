<?php

// Ejercicio 1

$cuenta = 1;

do{
echo $cuenta;
$cuenta = $cuenta+1;
} while ($cuenta <= 5);

// Ejercicio 2

$passw = 1234;
$input = 1234;


echo"<br>";

do {
    echo"Contraseña errónea. Intétalo de nuevo <br>";
} while ($input != $passw);

if ($passw = $input){
echo"Acceso permitido";
}
?>