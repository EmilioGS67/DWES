<?php
// Ejercicio 10 · Decimal a binario (sin decbin)

function aBinario($n)
{
    // Caso base: 0 o 1
    if ($n < 2) {
        return (string)$n;
    }
    // Caso recursivo: binario del cociente + resto de dividir entre 2
    return aBinario(intdiv($n, 2)) . ($n % 2);
}

echo 'aBinario(10) = "' . aBinario(10) . '"<br>'; // "1010"
echo 'aBinario(255) = "' . aBinario(255) . '"<br>'; // "11111111"
