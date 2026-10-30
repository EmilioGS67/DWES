<?php
function potencia($base, $exp){
    
    if ($exp == 0) return 1;

    return $base * potencia($base, $exp-1);
}

echo potencia(2, 5);
?>