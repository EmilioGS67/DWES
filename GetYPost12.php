<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Get y Post 12</title>
</head>
<body>

    <h2>Buscar usuario</h2>

    <form action="" method="GET">
        <label for="usuario">Nombre:</label>
        <input type="text" id="usuario" name="usuario" required>
        <br><br>

        <button type="submit">Buscar</button>
    </form>

    <hr>

    <h2>Registrar usuario</h2>

    <form action="" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required>
        <br><br>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" min="0" required>
        <br><br>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>
        <br><br>

        <button type="submit">Registrar</button>
    </form>

    <hr>

    <h2>Resultado</h2>

    <?php

    if (isset($_POST['nombre'], $_POST['apellidos'], $_POST['edad'], $_POST['correo'])) {

        $nombre    = htmlspecialchars(trim($_POST['nombre']));
        $apellidos = htmlspecialchars(trim($_POST['apellidos']));
        $edad      = trim($_POST['edad']);
        $correo    = htmlspecialchars(trim($_POST['correo']));

        if ($nombre === '' || $apellidos === '' || $edad === '' || $correo === '') {
            echo "<p>Todos los campos son obligatorios.</p>";
        } else if (!is_numeric($edad) || $edad < 0) {
            echo "<p>La edad introducida no es válida.</p>";
        } else if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            echo "<p>El correo introducido no es válido.</p>";
        } else {

            $edad = (int) $edad;

            if ($edad < 18) {
                $clasificacion = "Menor de edad";
            } else if ($edad <= 64) {
                $clasificacion = "Adulto";
            } else {
                $clasificacion = "Senior";
            }

            echo "<p>Nombre: $nombre</p>";
            echo "<p>Apellidos: $apellidos</p>";
            echo "<p>Edad: $edad</p>";
            echo "<p>Correo: $correo</p>";
            echo "<p>Es: $clasificacion</p>";
        }

    } else if (isset($_GET['usuario'])) {

        $usuario = htmlspecialchars(trim($_GET['usuario']));

        if ($usuario !== '') {
            echo "<p>Buscando usuario: $usuario</p>";
        } else {
            echo "<p>Introduce un nombre para buscar.</p>";
        }

    } else {
        echo "<p>No se ha realizado ninguna operación todavía.</p>";
    }

    ?>

</body>
</html>