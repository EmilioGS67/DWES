<?php

$regex = [
    'cp' => '/^[0-9]{5}$/D',

    'matricula' => '/^[0-9]{4}[BCDFGHJKLMNPRSTVWXYZ]{3}$/D',

    'nombre' => '/^\p{L}[\p{L} \'’-]{1,39}$/uD',

    'hora' => '/^([01][0-9]|2[0-3]):[0-5][0-9]$/D'
];

$etiquetas = [
    'cp'        => 'Código postal',
    'matricula' => 'Matrícula',
    'nombre'    => 'Nombre propio',
    'hora'      => 'Hora (HH:MM)'
];

$valores    = ['cp' => '', 'matricula' => '', 'nombre' => '', 'hora' => ''];
$resultados = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    foreach ($regex as $campo => $patron) {

        $valores[$campo] = isset($_POST[$campo]) && is_string($_POST[$campo]) ? trim($_POST[$campo]) : '';

        if ($valores[$campo] === '') {
            $resultados[$campo] = "Vacío";
        } else if (preg_match($patron, $valores[$campo]) === 1) {
            $resultados[$campo] = "Válido";
        } else {
            $resultados[$campo] = "No válido";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación 4</title>
</head>
<body>

    <h1>Expresiones regulares</h1>

    <h2>Las expresiones</h2>
    <ul>
        <?php foreach ($regex as $campo => $patron) { ?>
            <li><?php echo htmlspecialchars($etiquetas[$campo]); ?>: <code><?php echo htmlspecialchars($patron, ENT_QUOTES, 'UTF-8'); ?></code></li>
        <?php } ?>
    </ul>

    <h2>Pruébalas</h2>

    <form action="" method="POST">
        <?php foreach ($regex as $campo => $patron) { ?>
            <label for="<?php echo $campo; ?>"><?php echo htmlspecialchars($etiquetas[$campo]); ?>:</label>
            <input type="text" id="<?php echo $campo; ?>" name="<?php echo $campo; ?>" value="<?php echo htmlspecialchars($valores[$campo], ENT_QUOTES, 'UTF-8'); ?>">
            <?php if (isset($resultados[$campo])) { echo "<strong>" . $resultados[$campo] . "</strong>"; } ?>
            <br><br>
        <?php } ?>

        <button type="submit">Validar</button>
    </form>


</body>
</html>
