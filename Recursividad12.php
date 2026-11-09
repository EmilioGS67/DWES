<?php

function hanoi($n, $origen, $destino, $auxiliar)
{
    // Caso base: no hay discos que mover
    if ($n == 0) {
        return;
    }
    // Mover n-1 discos del origen al auxiliar
    hanoi($n - 1, $origen, $auxiliar, $destino);
    // Mover el disco más grande al destino
    echo "Mover disco $n de $origen a $destino<br>";
    // Mover los n-1 discos del auxiliar al destino
    hanoi($n - 1, $auxiliar, $destino, $origen);
}

echo "<h3>hanoi(3, \"A\", \"C\", \"B\")</h3>";
hanoi(3, "A", "C", "B"); 
