<?php
$logueado = true;
$administrador = false;
$voluntario = false;

echo var_dump($logueado && $administrador);
echo var_dump($voluntario || $administrador);
echo var_dump(!$logueado);
echo var_dump($voluntario xor $administrador);

echo"<br>";

$logueado = false;
$administrador = true;
$voluntario = true;

echo var_dump($logueado && $administrador);
echo var_dump($voluntario || $administrador);
echo var_dump(!$logueado);
echo var_dump($voluntario xor $administrador);
?>