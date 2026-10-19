<?php

// E4. Registro seguro (registro.php)
// Los usuarios se guardan en una base de datos SQLite (archivo usuarios.sqlite) con PDO.

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

function conectar(): PDO
{
    $bd = new PDO('sqlite:' . __DIR__ . '/usuarios.sqlite');
    $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // COLLATE NOCASE: "Ana" y "ana" se consideran el mismo usuario
    $bd->exec("CREATE TABLE IF NOT EXISTS usuarios (
                  id INTEGER PRIMARY KEY AUTOINCREMENT,
                  usuario TEXT NOT NULL UNIQUE COLLATE NOCASE,
                  password_hash TEXT NOT NULL)");

    return $bd;
}

$errores    = [];
$usuario    = '';
$registrado = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario  = isset($_POST['usuario'])  && is_string($_POST['usuario'])  ? trim($_POST['usuario']) : '';
    $password = isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password']      : '';

    // Usuario: 4 a 15 caracteres alfanuméricos o guion bajo
    if ($usuario === '') {
        $errores[] = "El usuario es obligatorio.";
    } else if (preg_match('/^[A-Za-z0-9_]{4,15}$/D', $usuario) !== 1) {
        $errores[] = "El usuario debe tener de 4 a 15 caracteres: letras, números o guion bajo.";
    }

    // Contraseña: mínimo 8 caracteres con mayúscula, minúscula y número
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

    if (count($errores) === 0) {
        try {
            $bd = conectar();

            // Consulta preparada: ¿existe ya el usuario?
            $consulta = $bd->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = :usuario");
            $consulta->execute([':usuario' => $usuario]);

            if ((int) $consulta->fetchColumn() > 0) {
                $errores[] = "Ese nombre de usuario ya está en uso.";
            } else {
                // La contraseña NUNCA se guarda en claro: password_hash genera un hash con sal incluida
                $insertar = $bd->prepare("INSERT INTO usuarios (usuario, password_hash) VALUES (:usuario, :hash)");
                $insertar->execute([
                    ':usuario' => $usuario,
                    ':hash'    => password_hash($password, PASSWORD_DEFAULT)
                ]);

                $registrado = true;
            }
        } catch (PDOException $ex) {
            error_log($ex->getMessage());
            $errores[] = "No se ha podido completar el registro. Inténtalo más tarde.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación E4 - Registro</title>
</head>
<body>

    <h1>Registro</h1>

    <?php if ($registrado) { ?>

        <p><strong>Usuario <?php echo e($usuario); ?> registrado correctamente.</strong></p>
        <p><a href="Validaci%C3%B3n%20E4%20login.php">Ir al login</a></p>

    <?php } else { ?>

        <?php if (count($errores) > 0) { ?>
            <ul>
                <?php foreach ($errores as $error) { ?>
                    <li><?php echo e($error); ?></li>
                <?php } ?>
            </ul>
        <?php } ?>

        <form action="" method="POST">
            <label for="usuario">Usuario (4-15: letras, números o _):</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo e($usuario); ?>">
            <br><br>

            <label for="password">Contraseña (mín. 8, mayúscula, minúscula y número):</label>
            <input type="password" id="password" name="password">
            <br><br>

            <button type="submit">Registrarse</button>
        </form>

        <p><a href="Validaci%C3%B3n%20E4%20login.php">Ya tengo cuenta</a></p>

    <?php } ?>

</body>
</html>
