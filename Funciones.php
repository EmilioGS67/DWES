<?php

function validarDNI(string $dni): bool
{
    $dni = strtoupper(trim($dni));

    if (preg_match('/^[0-9]{8}[A-Z]$/D', $dni) !== 1) {
        return false;
    }

    $letras = 'TRWAGMYFPDXBNJZSQVHLCKE';
    $numero = (int) substr($dni, 0, 8);

    return $dni[8] === $letras[$numero % 23];
}

function validarTelefono(string $telefono): bool
{
    $telefono = str_replace(' ', '', trim($telefono));

    return preg_match('/^[6-9][0-9]{8}$/D', $telefono) === 1;
}

function validarCP(string $cp): bool
{
    return preg_match('/^(0[1-9]|[1-4][0-9]|5[0-2])[0-9]{3}$/D', trim($cp)) === 1;
}


function validarMatricula(string $matricula): bool
{
    $matricula = strtoupper(trim($matricula));

    return preg_match('/^[0-9]{4}[BCDFGHJKLMNPRSTVWXYZ]{3}$/D', $matricula) === 1;
}
