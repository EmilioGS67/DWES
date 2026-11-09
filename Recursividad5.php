<?php
function sumaDigitos($n)
{
    if ($n < 10) {
        return $n;
    }

    return ($n % 10) + sumaDigitos(intdiv($n, 10));
}

echo "sumaDigitos(1234) = " . sumaDigitos(1234) . "<br>"; 
echo "sumaDigitos(99) = " . sumaDigitos(99) . "<br>";     
