<?php
// Ejercicio 7 · Palíndromo

function esPalindromo($s)
{
    // Caso base: vacía o de un solo carácter -> es palíndromo
    if (strlen($s) <= 1) {
        return true;
    }
    // Si los extremos son distintos, no es palíndromo
    if ($s[0] !== $s[strlen($s) - 1]) {
        return false;
    }
    // Caso recursivo: comprobar lo que queda sin los extremos
    return esPalindromo(substr($s, 1, -1));
}

function mostrar($valor)
{
    return $valor ? "true" : "false";
}

echo 'esPalindromo("reconocer") = ' . mostrar(esPalindromo("reconocer")) . "<br>"; // true
echo 'esPalindromo("php") = ' . mostrar(esPalindromo("php")) . "<br>";             // false
