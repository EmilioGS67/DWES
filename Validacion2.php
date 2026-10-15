<?php

$mensaje = '';
$edad    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edad'])) {

    $edad = trim($_POST['edad']);

    $opciones = [
        'options' => [
            'min_range' => 18,
            'max_range' => 99
        ]
    ];

    $resultado = filter_var($edad, FILTER_VALIDATE_INT, $opciones);

    if ($edad === '') {
        $mensaje = "Debes introducir una edad.";
    } else if ($resultado === false) {
        $mensaje = "Edad no válida: debe ser un número entero entre 18 y 99.";
    } else {
        $mensaje = "Edad correcta: $resultado años.";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación A2</title>
</head>
<body>

    <h1>A2. Validar una edad (18-99)</h1>

    <form action="" method="POST">
        <label for="edad">Edad:</label>
        <input type="text" id="edad" name="edad" value="<?php echo htmlspecialchars($edad, ENT_QUOTES, 'UTF-8'); ?>">
        <br><br>

        <button type="submit">Validar</button>
    </form>

    <hr>

    <?php
    if ($mensaje !== '') {
        echo "<p><strong>" . htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') . "</strong></p>";
    } else {
        echo "<p>Introduce una edad para validarla.</p>";
    }
    ?>

    <p>Pruebas sugeridas: 17 (no), 18 (sí), 99 (sí), 100 (no), 25.5 (no), abc (no), 018 (no).</p>

</body>
</html>
