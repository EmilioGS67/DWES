<?php


date_default_timezone_set('Europe/Madrid');

$guardarEnBD = false;

function validarDNI(string $dni): bool
{
    $dni = strtoupper(trim($dni));

    if (preg_match('/^[0-9]{8}[A-Z]$/D', $dni) !== 1) {
        return false;
    }

    $letras = 'TRWAGMYFPDXBNJZSQVHLCKE';
    return $dni[8] === $letras[((int) substr($dni, 0, 8)) % 23];
}

function validarFecha(string $fecha): bool
{
    if (preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/D', $fecha, $p) !== 1) {
        return false;
    }

    return checkdate((int) $p[2], (int) $p[1], (int) $p[3]);
}

function validarFechaNacimiento(string $fecha): bool
{
    if (!validarFecha($fecha)) {
        return false;
    }

    $nacimiento = DateTime::createFromFormat('!d/m/Y', $fecha);
    $hoy        = new DateTime('today');

    if ($nacimiento === false || $nacimiento > $hoy) {
        return false;
    }

    $edad = $nacimiento->diff($hoy);

    return !($edad->y > 120 || ($edad->y === 120 && ($edad->m > 0 || $edad->d > 0)));
}

function campo(string $nombre): string
{
    return isset($_POST[$nombre]) && is_string($_POST[$nombre]) ? trim($_POST[$nombre]) : '';
}

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

$errores   = [];
$valores   = ['nombre' => '', 'email' => '', 'telefono' => '', 'dni' => '', 'cp' => '', 'fecha' => ''];
$bienvenida = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    foreach ($valores as $clave => $v) {
        $valores[$clave] = campo($clave);
    }

    $password  = isset($_POST['password'])  && is_string($_POST['password'])  ? $_POST['password']  : '';
    $password2 = isset($_POST['password2']) && is_string($_POST['password2']) ? $_POST['password2'] : '';

    if ($valores['nombre'] === '') {
        $errores[] = "El nombre es obligatorio.";
    } else if (preg_match('/^\p{L}[\p{L} \'’-]{1,39}$/uD', $valores['nombre']) !== 1) {
        $errores[] = "El nombre no es válido (2-40 letras, espacios, guiones o apóstrofos).";
    }

    if ($valores['email'] === '') {
        $errores[] = "El email es obligatorio.";
    } else if (filter_var($valores['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errores[] = "El email no es válido.";
    }

    $telefonoLimpio = str_replace(' ', '', $valores['telefono']);
    if ($valores['telefono'] === '') {
        $errores[] = "El teléfono es obligatorio.";
    } else if (preg_match('/^[6-9][0-9]{8}$/D', $telefonoLimpio) !== 1) {
        $errores[] = "El teléfono no es válido (9 dígitos, empieza por 6, 7, 8 o 9).";
    }

    if ($valores['dni'] === '') {
        $errores[] = "El DNI es obligatorio.";
    } else if (!validarDNI($valores['dni'])) {
        $errores[] = "El DNI no es válido (formato o letra incorrectos).";
    }

    if ($valores['cp'] === '') {
        $errores[] = "El código postal es obligatorio.";
    } else if (preg_match('/^(0[1-9]|[1-4][0-9]|5[0-2])[0-9]{3}$/D', $valores['cp']) !== 1) {
        $errores[] = "El código postal no es válido (5 dígitos, provincia 01-52).";
    }

    if ($valores['fecha'] === '') {
        $errores[] = "La fecha de nacimiento es obligatoria.";
    } else if (!validarFechaNacimiento($valores['fecha'])) {
        $errores[] = "La fecha de nacimiento no es válida (DD/MM/AAAA, existente, no futura y de menos de 120 años).";
    }

    if ($password === '') {
        $errores[] = "La contraseña es obligatoria.";
    } else {
        if (mb_strlen($password) < 8) {
            $errores[] = "La contraseña debe tener al menos 8 caracteres.";
        }
        if (preg_match('/[A-Z]/', $password) !== 1) {
            $errores[] = "La contraseña debe tener al menos una mayúscula.";
        }
        if (preg_match('/[a-z]/', $password) !== 1) {
            $errores[] = "La contraseña debe tener al menos una minúscula.";
        }
        if (preg_match('/[0-9]/', $password) !== 1) {
            $errores[] = "La contraseña debe tener al menos un número.";
        }
    }

    if ($password !== $password2) {
        $errores[] = "Las contraseñas no coinciden.";
    }


    if (count($errores) === 0) {

        if ($guardarEnBD) {
            try {
                $bd = new PDO('sqlite:' . __DIR__ . '/validacion_d1.sqlite');
                $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $bd->exec("CREATE TABLE IF NOT EXISTS usuarios (
                              id INTEGER PRIMARY KEY AUTOINCREMENT,
                              nombre TEXT NOT NULL,
                              email TEXT NOT NULL UNIQUE,
                              telefono TEXT NOT NULL,
                              dni TEXT NOT NULL,
                              cp TEXT NOT NULL,
                              fecha_nacimiento TEXT NOT NULL,
                              password_hash TEXT NOT NULL)");

                $consulta = $bd->prepare("INSERT INTO usuarios (nombre, email, telefono, dni, cp, fecha_nacimiento, password_hash)
                                          VALUES (:nombre, :email, :telefono, :dni, :cp, :fecha, :hash)");
                $consulta->execute([
                    ':nombre' => $valores['nombre'],
                    ':email' => $valores['email'],
                    ':telefono' => $telefonoLimpio,
                    ':dni' => strtoupper($valores['dni']),
                    ':cp' => $valores['cp'],
                    ':fecha' => $valores['fecha'],
                    ':hash' => password_hash($password, PASSWORD_DEFAULT)
                ]);
            } catch (PDOException $ex) {
                error_log($ex->getMessage());
                $errores[] = "No se ha podido guardar el registro (¿el email ya está registrado?).";
            }
        }

        if (count($errores) === 0) {
            $bienvenida = "¡Bienvenido/a, " . e($valores['nombre']) . "! Tu registro se ha completado correctamente.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación D1</title>
</head>
<body>

    <h1>Registro de usuario</h1>

    <?php if ($bienvenida !== '') { ?>

        <p><strong><?php echo $bienvenida; ?></strong></p>

    <?php } else { ?>

        <?php if (count($errores) > 0) { ?>
            <p><strong>Se han encontrado los siguientes errores:</strong></p>
            <ul>
                <?php foreach ($errores as $error) { ?>
                    <li><?php echo e($error); ?></li>
                <?php } ?>
            </ul>
        <?php } ?>

        <form action="" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo e($valores['nombre']); ?>">
            <br><br>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo e($valores['email']); ?>">
            <br><br>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo e($valores['telefono']); ?>">
            <br><br>

            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" value="<?php echo e($valores['dni']); ?>">
            <br><br>

            <label for="cp">Código postal:</label>
            <input type="text" id="cp" name="cp" value="<?php echo e($valores['cp']); ?>">
            <br><br>

            <label for="fecha">Fecha de nacimiento (DD/MM/AAAA):</label>
            <input type="text" id="fecha" name="fecha" value="<?php echo e($valores['fecha']); ?>">
            <br><br>

            <!-- Las contraseñas nunca se vuelven a escribir en el formulario -->
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password">
            <br><br>

            <label for="password2">Repetir contraseña:</label>
            <input type="password" id="password2" name="password2">
            <br><br>

            <button type="submit">Registrarse</button>
        </form>

    <?php } ?>

</body>
</html>
