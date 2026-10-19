<?php

date_default_timezone_set('Europe/Madrid');

function validarFecha(string $fecha): bool
{
    if (preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/D', $fecha, $partes) !== 1) {
        return false;
    }

    return checkdate((int) $partes[2], (int) $partes[1], (int) $partes[3]);
}

function validarFechaNacimiento(string $fecha): bool
{
    if (!validarFecha($fecha)) {
        return false;
    }

    $nacimiento = DateTime::createFromFormat('!d/m/Y', $fecha);
    $hoy        = new DateTime('today');

    if ($nacimiento === false) {
        return false;
    }

    // 3) No puede ser una fecha futura
    if ($nacimiento > $hoy) {
        return false;
    }

    // 4) No puede tener más de 120 años
    $edad = $nacimiento->diff($hoy);

    if ($edad->y > 120 || ($edad->y === 120 && ($edad->m > 0 || $edad->d > 0))) {
        return false;
    }

    return true;
}

$manana = (new DateTime('tomorrow'))->format('d/m/Y');
$hoyTxt = (new DateTime('today'))->format('d/m/Y');
$hace120 = (new DateTime('today'))->modify('-120 years')->format('d/m/Y');
$hace120y1 = (new DateTime('today'))->modify('-120 years -1 day')->format('d/m/Y');

$pruebas = [
    '15/05/2000' => ['Fecha normal', true],
    '29/02/2000' => ['Bisiesto', true],
    '31/02/2000' => ['No existe', false],
    '99/99/2000' => ['No existe', false],
    $hoyTxt => ['Hoy (límite)', true],
    $manana => ['Mañana (futura)', false],
    '01/01/2999' => ['Futura', false],
    $hace120     => ['Exactamente 120 años (límite)', true],
    $hace120y1   => ['120 años y 1 día', false],
    '01/01/1800' => ['Demasiado antigua', false],
    '1/1/2000'   => ['Formato incorrecto', false]
];

$fechaUsuario = '';
$resultado    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fecha']) && is_string($_POST['fecha'])) {
    $fechaUsuario = trim($_POST['fecha']);
    $resultado    = validarFechaNacimiento($fechaUsuario) ? "Fecha de nacimiento válida" : "Fecha de nacimiento no válida";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación B3</title>
</head>
<body>

    <h1>Validar fecha de nacimiento</h1>

    <h2>Pruebas automáticas</h2>
    <table border="1" cellpadding="4">
        <tr><th>Fecha</th><th>Caso</th><th>Esperado</th><th>Obtenido</th><th>Resultado</th></tr>
        <?php foreach ($pruebas as $fecha => $datos) {
            $obtenido = validarFechaNacimiento((string) $fecha); ?>
            <tr>
                <td><?php echo htmlspecialchars((string) $fecha); ?></td>
                <td><?php echo htmlspecialchars($datos[0]); ?></td>
                <td><?php echo $datos[1] ? 'Válida' : 'No válida'; ?></td>
                <td><?php echo $obtenido ? 'Válida' : 'No válida'; ?></td>
                <td><?php echo $obtenido === $datos[1] ? 'OK' : 'FALLO'; ?></td>
            </tr>
        <?php } ?>
    </table>

    <h2>Prueba tú mismo</h2>

    <form action="" method="POST">
        <label for="fecha">Fecha de nacimiento (DD/MM/AAAA):</label>
        <input type="text" id="fecha" name="fecha" value="<?php echo htmlspecialchars($fechaUsuario, ENT_QUOTES, 'UTF-8'); ?>">
        <br><br>
        <button type="submit">Validar</button>
    </form>

    <?php if ($resultado !== '') { echo "<p><strong>$resultado</strong></p>"; } ?>

</body>
</html>
