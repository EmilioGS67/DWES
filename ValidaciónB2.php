<?php


function validarFecha(string $fecha): bool
{
    if (preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/D', $fecha, $partes) !== 1) {
        return false;
    }

    $dia  = (int) $partes[1];
    $mes  = (int) $partes[2];
    $anio = (int) $partes[3];

    return checkdate($mes, $dia, $anio);
}

$pruebas = [
    '29/02/2024' => true,   // bisiesto
    '31/02/2025' => false,  // febrero no tiene 31 días
    '99/99/2025' => false,  // día y mes imposibles
    '29/02/2025' => false,  // 2025 no es bisiesto
    '31/04/2025' => false,  // abril tiene 30 días
    '31/12/2025' => true,
    '1/1/2025'   => false,  // formato incorrecto (faltan ceros)
    '2025-01-01' => false   // otro formato
];

$fechaUsuario = '';
$resultado = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fecha']) && is_string($_POST['fecha'])) {
    $fechaUsuario = trim($_POST['fecha']);
    $resultado    = validarFecha($fechaUsuario) ? "Fecha válida" : "Fecha no válida";
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación B2</title>
</head>
<body>

    <h1>Validar fecha DD/MM/AAAA</h1>

    <h2>Pruebas automáticas</h2>
    <table border="1" cellpadding="4">
        <tr><th>Fecha</th><th>Esperado</th><th>Obtenido</th><th>Resultado</th></tr>
        <?php foreach ($pruebas as $fecha => $esperado) {
            $obtenido = validarFecha($fecha); ?>
            <tr>
                <td><?php echo htmlspecialchars($fecha); ?></td>
                <td><?php echo $esperado ? 'Válida' : 'No válida'; ?></td>
                <td><?php echo $obtenido ? 'Válida' : 'No válida'; ?></td>
                <td><?php echo $obtenido === $esperado ? 'OK' : 'FALLO'; ?></td>
            </tr>
        <?php } ?>
    </table>

    <h2>Prueba tú mismo</h2>

    <form action="" method="POST">
        <label for="fecha">Fecha (DD/MM/AAAA):</label>
        <input type="text" id="fecha" name="fecha" value="<?php echo htmlspecialchars($fechaUsuario, ENT_QUOTES, 'UTF-8'); ?>">
        <br><br>
        <button type="submit">Validar</button>
    </form>

    <?php if ($resultado !== '') { echo "<p><strong>$resultado</strong></p>"; } ?>

</body>
</html>
