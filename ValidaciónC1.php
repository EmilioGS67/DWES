<?php

$errores = [];
$nombre = '';
$email = '';
$edad = '';
$bienvenida = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = isset($_POST['nombre']) && is_string($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $email  = isset($_POST['email'])  && is_string($_POST['email'])  ? trim($_POST['email'])  : '';
    $edad   = isset($_POST['edad'])   && is_string($_POST['edad'])   ? trim($_POST['edad'])   : '';

    if ($nombre === '') {
        $errores[] = "El nombre es obligatorio.";
    } else if (preg_match('/^\p{L}[\p{L} \'’-]{1,39}$/uD', $nombre) !== 1) {
        $errores[] = "El nombre no es válido (2-40 letras, espacios, guiones o apóstrofos).";
    }

    if ($email === '') {
        $errores[] = "El email es obligatorio.";
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errores[] = "El email no es válido.";
    }

    $edadValida = filter_var($edad, FILTER_VALIDATE_INT, ['options' => ['min_range' => 18, 'max_range' => 99]]);
    if ($edad === '') {
        $errores[] = "La edad es obligatoria.";
    } else if ($edadValida === false) {
        $errores[] = "La edad debe ser un entero entre 18 y 99.";
    }

    if (count($errores) === 0) {
        try {
            $conexion = new PDO('sqlite:' . __DIR__ . '/validacion_c1.sqlite');
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $conexion->exec("CREATE TABLE IF NOT EXISTS usuarios (
                                id INTEGER PRIMARY KEY AUTOINCREMENT,
                                nombre TEXT NOT NULL,
                                email TEXT NOT NULL,
                                edad INTEGER NOT NULL)");

            $consulta = $conexion->prepare("INSERT INTO usuarios (nombre, email, edad) VALUES (:nombre, :email, :edad)");
            $consulta->execute([
                ':nombre' => $nombre,
                ':email'  => $email,
                ':edad'   => $edadValida
            ]);

            $bienvenida = "Bienvenido, " . htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');

        } catch (PDOException $e) {

            error_log($e->getMessage());
            $errores[] = "No se ha podido guardar el usuario. Inténtalo más tarde.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación C1</title>
</head>
<body>

    <h1>Código corregido</h1>

    <h2>Problemas del código original</h2>
    <ol>
        <li>No se comprueba que los campos de <code>$_POST</code> existan.</li>
        <li>El email solo se comprueba con <code>!$email</code>; falta <code>filter_var</code>.</li>
        <li>Nombre y edad no se validan (la edad debería ser un entero con rango).</li>
        <li>Inyección SQL: variables concatenadas en la consulta (y <code>$edad</code> sin comillas).</li>
        <li>Si falta el email, el código muestra el aviso pero sigue y ejecuta el INSERT.</li>
        <li>XSS: <code>echo $nombre</code> sin <code>htmlspecialchars</code>.</li>
        <li>No hay consulta preparada ni gestión de errores de la base de datos.</li>
    </ol>

    <h2>Formulario</h2>

    <?php if (count($errores) > 0) { ?>
        <ul>
            <?php foreach ($errores as $error) { ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php } ?>
        </ul>
    <?php } ?>

    <?php if ($bienvenida !== '') { echo "<p><strong>$bienvenida</strong></p>"; } ?>

    <form action="" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8'); ?>">
        <br><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
        <br><br>

        <label for="edad">Edad:</label>
        <input type="text" id="edad" name="edad" value="<?php echo htmlspecialchars($edad, ENT_QUOTES, 'UTF-8'); ?>">
        <br><br>

        <button type="submit">Registrar</button>
    </form>

</body>
</html>
