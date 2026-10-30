<?php
// Ejercicio 9 · Máximo común divisor (algoritmo de Euclides)

function mcd($a, $b)
{
    // Caso base: cuando el divisor es 0, el resultado es $a
    if ($b == 0) {
        return $a;
    }
    // Caso recursivo: mcd(a, b) = mcd(b, a mod b)
    return mcd($b, $a % $b);
}

echo "mcd(48, 18) = " . mcd(48, 18) . "<br>"; // 6
echo "mcd(100, 75) = " . mcd(100, 75) . "<br>"; // 25
