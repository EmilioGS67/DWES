<?php
// Ejercicio 4 · Contar dígitos

function contarDigitos($n)
{
    // Caso base: un solo dígito
    if ($n < 10) {
        return 1;
    }
    // Caso recursivo: quitamos el último dígito y sumamos 1
    return 1 + contarDigitos(intdiv($n, 10));
}

echo "contarDigitos(12345) = " . contarDigitos(12345) . "<br>"; // 5
echo "contarDigitos(7) = " . contarDigitos(7) . "<br>";         // 1
