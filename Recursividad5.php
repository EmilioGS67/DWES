<?php
// Ejercicio 5 · Suma de los dígitos

function sumaDigitos($n)
{
    // Caso base: un solo dígito
    if ($n < 10) {
        return $n;
    }
    // Caso recursivo: último dígito + suma del resto
    return ($n % 10) + sumaDigitos(intdiv($n, 10));
}

echo "sumaDigitos(1234) = " . sumaDigitos(1234) . "<br>"; // 10
echo "sumaDigitos(99) = " . sumaDigitos(99) . "<br>";     // 18
