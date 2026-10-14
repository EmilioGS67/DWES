<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Get y Post 11</title>
</head>
<body>

    <h2>Búsqueda de productos</h2>

    <form action="" method="GET">
        <label for="producto">Producto:</label>
        <input type="text" id="producto" name="producto" required>
        <br><br>

        <button type="submit">Buscar</button>
    </form>

    <hr>

    <h2>Registro de usuario</h2>

    <form action="" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>
        <br><br>

        <label for="ciudad">Ciudad:</label>
        <input type="text" id="ciudad" name="ciudad" required>
        <br><br>

        <button type="submit">Registrarse</button>
    </form>

    <hr>

    <h2>Resultado</h2>

    <?php

    if (isset($_POST['nombre'], $_POST['correo'], $_POST['ciudad'])) {

        $nombre = htmlspecialchars(trim($_POST['nombre']));
        $correo = htmlspecialchars(trim($_POST['correo']));
        $ciudad = htmlspecialchars(trim($_POST['ciudad']));

        if ($nombre === '' || $correo === '' || $ciudad === '') {
            echo "<p>Todos los campos son obligatorios.</p>";
        } else if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            echo "<p>El correo introducido no es válido.</p>";
        } else {

            echo "<p>Nombre: $nombre</p>";
            echo "<p>Correo: $correo</p>";
            echo "<p>Ciudad: $ciudad</p>";
        }

    } else if (isset($_GET['producto'])) {

        $producto = htmlspecialchars(trim($_GET['producto']));

        if ($producto !== '') {

            echo "<p>Producto: $producto </p>";
        } else {
            echo "<p>Introduce el nombre de un producto para buscar.</p>";
        }

    } else {
        echo "<p>No se ha realizado ninguna operación todavía.</p>";
    }

    ?>

</body>
</html>