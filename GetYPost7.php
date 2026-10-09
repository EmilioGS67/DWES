<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Get y Post 7</title>
</head>
<body>

    <h2>Introduce el producto a buscar</h2>

    <form action="" method="GET">
        <label for="producto">Producto:</label>
        <input type="text" id="producto" name="producto" required>
        <br><br>
        
        <button type="submit1">Enviar</button>
    </form>

    <br>

    <h2>Introduce tus credenciales</h2>

    <form action="" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>

        <label for="correo">Correo electrónico:</label>
        <input type="email" id="correo" name="correo" required>
        <br><br>
        
        <button type="submit2">Enviar</button>
    </form>

    <br>

    <?php

    if (isset($_GET['producto'])) {
        
        $producto = htmlspecialchars($_GET['producto']);
        echo "<p>Producto: " . $producto . "</p>";

    }

    if ($_POST['nombre'] && $_POST['correo']) {

        $nombre = htmlspecialchars($_POST['nombre']);
        echo "<p>Nombre: " . $nombre . "</p>";

        $correo = htmlspecialchars($_POST['correo']);
        echo "<p>Correo electrónico: " . $correo . "</p>";

    }

    ?>

</body>
</html>

