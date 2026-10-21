<?php

session_start();

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function conectar(): PDO
{
    $bd = new PDO('sqlite:' . __DIR__ . '/usuarios.sqlite');
    $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $bd->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        usuario TEXT NOT NULL UNIQUE COLLATE NOCASE,
        password_hash TEXT NOT NULL)");

    return $bd;
}

// Mensaje para cualquier fallo de acceso
$mensajeError = "Usuario o contraseña incorrectos";

$error   = '';
$usuario = '';

// Cerrar sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salir'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Iniciar sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['entrar'])) {

    $usuario  = isset($_POST['usuario'])  && is_string($_POST['usuario'])  ? trim($_POST['usuario']) : '';
    $password = isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password']      : '';

    if ($usuario === '' || $password === '') {
        $error = $mensajeError;
    } else if (preg_match('/^[A-Za-z0-9_]{4,15}$/D', $usuario) !== 1) {
        // Un usuario con formato imposible no puede existir
        $error = $mensajeError;
    } else {
        try {
            $bd = conectar();

            $consulta = $bd->prepare("SELECT usuario, password_hash FROM usuarios WHERE usuario = :usuario");
            $consulta->execute([':usuario' => $usuario]);
            $fila = $consulta->fetch(PDO::FETCH_ASSOC);

            // Si el usuario no existe se verifica contra un hash falso para que la respuesta tarde
            // lo mismo y no delate si el usuario existe o no
            $hash = $fila ? $fila['password_hash'] : password_hash('hash-de-relleno', PASSWORD_DEFAULT);
            $correcta = password_verify($password, $hash);

            if ($fila && $correcta) {
                // Evita la fijación de sesión
                session_regenerate_id(true);
                $_SESSION['usuario'] = $fila['usuario'];
            } else {
                $error = $mensajeError;
            }
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            $error = "No se ha podido iniciar sesión. Inténtalo más tarde.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

    <h1>Login</h1>

    <?php if (isset($_SESSION['usuario'])) { ?>

        <p><strong>Bienvenido, <?php echo e($_SESSION['usuario']); ?>.</strong></p>

        <form action="" method="POST">
            <button type="submit" name="salir">Cerrar sesión</button>
        </form>

    <?php } else { ?>

        <?php if ($error !== '') { echo "<p><strong>" . e($error) . "</strong></p>"; } ?>

        <form action="" method="POST">
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo e($usuario); ?>">
            <br><br>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password">
            <br><br>

            <button type="submit" name="entrar">Entrar</button>
        </form>

        <p><a href="Validaci%C3%B3n%20E4%20registro.php">Crear una cuenta</a></p>

    <?php } ?>

    <hr>

    <h2>Pregunta de reflexión</h2>
    <p><strong>¿Por qué el login debe responder siempre "Usuario o contraseña incorrectos" en lugar de decir cuál de los dos falla?</strong></p>
    <p>Porque si la aplicación dijera "ese usuario no existe" o "la contraseña es incorrecta", un atacante podría
       <em>enumerar usuarios</em>: probar nombres hasta encontrar los que existen. Una vez tiene una lista de usuarios válidos,
       puede concentrar ataques de fuerza bruta, de relleno de credenciales (credential stuffing) o de phishing solo sobre
       cuentas reales, lo que le ahorra mucho trabajo. Con un mensaje único (y un tiempo de respuesta parecido en ambos casos)
       el atacante no sabe cuál de los dos datos ha fallado. Conviene completarlo limitando el número de intentos de acceso.</p>

</body>
</html>
