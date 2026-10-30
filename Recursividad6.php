<?php
// Ejercicio 6 · Invertir una cadena (sin strrev)

function invertir($texto)
{
    // Caso base: cadena vacía o de un solo carácter
    if (strlen($texto) <= 1) {
        return $texto;
    }
    // Caso recursivo: invertir el resto y poner el primer carácter al final
    return invertir(substr($texto, 1)) . $texto[0];
}

echo 'invertir("daw") = ' . invertir("daw") . "<br>";   // wad
echo 'invertir("hola") = ' . invertir("hola") . "<br>"; // aloh
