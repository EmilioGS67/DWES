<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Get y Post 3</title>
</head>
<body>

    <h2>Introduce el producto a buscar:</h2>

    <form action="" method="get">
        <label for="Producto">producto:</label>
        <input type="text" id="producto" name="producto" required>
        <br><br>
        
        <button type="submit">Enviar</button>
    </form>

    <br>

    <?php

    if (isset($_GET['producto'])) {
        
        $producto = htmlspecialchars($_GET['producto']);

        echo "<p>Producto buscado: " . $producto . "</p>";
    }
    ?>

</body>
</html>

