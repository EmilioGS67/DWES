<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Get y Post 8</title>
</head>
<body>

    <h2>Introduce tus edad</h2>

    <form action="" method="post">
        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required>
        <br><br>
        
        <button type="submit">Enviar</button>
    </form>

    <br>

    <?php

if ($_POST['edad']) {

    $edad = htmlspecialchars($_POST['edad']);

    if ($edad < 18) {

        echo "Menor de edad";
    } else {
        echo "Mayor de edad";
    }
}
    ?>

</body>
</html>

