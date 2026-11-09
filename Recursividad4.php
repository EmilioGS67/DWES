<?php
function contarDigitos($n)
{
    if ($n < 10) {
        return 1;
    }

    return 1 + contarDigitos(intdiv($n, 10));
}

echo "contarDigitos(12345) = " . contarDigitos(12345) . "<br>"; 
echo "contarDigitos(7) = " . contarDigitos(7) . "<br>";        
