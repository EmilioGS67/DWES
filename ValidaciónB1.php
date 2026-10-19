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

// Casos de prueba
$pruebas = [
    '12345678Z' => true,   // válido
    '12345678A' => false,  // letra incorrecta
    '12345678z' => true,   // minúscula: se normaliza
    '1234567Z'  => false,  // solo 7 números
    '12345678'  => false,  // falta la letra
    'ABCDEFGHZ' => false   // no son números
];

$dniUsuario = '';
$resultado = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dni']) && is_string($_POST['dni'])) {
    $dniUsuario = trim($_POST['dni']);
    $resultado  = validarDNI($dniUsuario) ? "DNI válido" : "DNI no válido";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación B1</title>
</head>
<body>

    <h1>Validar DNI</h1>

    <h2>Pruebas automáticas</h2>
    <table border="1" cellpadding="4">
        <tr><th>DNI</th><th>Esperado</th><th>Obtenido</th><th>Resultado</th></tr>
        <?php foreach ($pruebas as $dni => $esperado) {
            $obtenido = validarDNI($dni); ?>
            <tr>
                <td><?php echo htmlspecialchars($dni); ?></td>
                <td><?php echo $esperado ? 'Válido' : 'No válido'; ?></td>
                <td><?php echo $obtenido ? 'Válido' : 'No válido'; ?></td>
                <td><?php echo $obtenido === $esperado ? 'OK' : 'FALLO'; ?></td>
            </tr>
        <?php } ?>
    </table>

    <h2>Prueba tú mismo</h2>

    <form action="" method="POST">
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" value="<?php echo htmlspecialchars($dniUsuario, ENT_QUOTES, 'UTF-8'); ?>">
        <br><br>
        <button type="submit">Validar</button>
    </form>

    <?php if ($resultado !== '') { echo "<p><strong>$resultado</strong></p>"; } ?>

</body>
</html>
