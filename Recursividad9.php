<?php
function mcd($a, $b)
{
    if ($b == 0) {
        return $a;
    }

    return mcd($b, $a % $b);
}

echo mcd(48, 18) . "<br>";
