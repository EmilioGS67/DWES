<?php

// Catálogo de cursos organizado por nivel
$cursos = [
    "Iniciación" => ["HTML", "Introducción a la programación", "Ofimática"],
    "Intermedio" => ["PHP", "JavaScript", "Bases de datos"],
    "Avanzado"   => ["Desarrollo web con frameworks", "Seguridad informática", "Arquitectura de software"]
];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Academia online</title>
</head>
<body>

    <h1>Academia online</h1>

    <h2>Consulta del catálogo</h2>

    <form action="" method="GET">
        <label for="nivel">Nivel:</label>
        <select id="nivel" name="nivel" required>
            <option value="">Selecciona un nivel</option>
            <?php foreach ($cursos as $nivel => $lista) { ?>
                <option value="<?php echo htmlspecialchars($nivel); ?>"><?php echo htmlspecialchars($nivel); ?></option>
            <?php } ?>
        </select>
        <br><br>

        <button type="submit">Consultar</button>
    </form>

    <?php

    // Resultado de la consulta 
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['nivel'])) {

        $nivel = trim($_GET['nivel']);

        if ($nivel === '') {
            echo "<p>Selecciona un nivel para consultar.</p>";
        } else if (!array_key_exists($nivel, $cursos)) {
            echo "<p>El nivel seleccionado no es válido.</p>";
        } else {
            echo "<h3>Cursos de nivel " . htmlspecialchars(mb_strtolower($nivel)) . "</h3>";
            echo "<ul>";
            foreach ($cursos[$nivel] as $curso) {
                echo "<li>" . htmlspecialchars($curso) . "</li>";
            }
            echo "</ul>";
        }
    }

    ?>

    <hr>

    <h2>Matrícula</h2>

    <form action="" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required>
        <br><br>

        <label for="curso">Curso:</label>
        <select id="curso" name="curso" required>
            <option value="">Selecciona un curso</option>
            <?php foreach ($cursos as $nivel => $lista) { ?>
                <optgroup label="<?php echo htmlspecialchars($nivel); ?>">
                    <?php foreach ($lista as $curso) { ?>
                        <option value="<?php echo htmlspecialchars($curso); ?>"><?php echo htmlspecialchars($curso); ?></option>
                    <?php } ?>
                </optgroup>
            <?php } ?>
        </select>
        <br><br>

        <label for="edad">Edad:</label>
        <input type="number" id="edad" name="edad" required>
        <br><br>

        <label for="horas">Horas semanales disponibles:</label>
        <input type="number" id="horas" name="horas" step="any" required>
        <br><br>

        <button type="submit">Matricularse</button>
    </form>

    <hr>

    <h2>Resultado de la matrícula</h2>

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'], $_POST['apellidos'], $_POST['curso'], $_POST['edad'], $_POST['horas'])) {

        $nombre    = htmlspecialchars(trim($_POST['nombre']));
        $apellidos = htmlspecialchars(trim($_POST['apellidos']));
        $curso     = trim($_POST['curso']);
        $edad      = trim($_POST['edad']);
        $horas     = trim($_POST['horas']);

        // Comprueba si el curso existe
        $cursoValido = false;
        foreach ($cursos as $lista) {
            if (in_array($curso, $lista, true)) {
                $cursoValido = true;
            }
        }

        if ($nombre === '' || $apellidos === '' || $curso === '' || $edad === '' || $horas === '') {
            echo "<p>Todos los campos son obligatorios.</p>";
        } else if (!$cursoValido) {
            echo "<p>El curso seleccionado no es válido.</p>";
        } else if (filter_var($edad, FILTER_VALIDATE_INT) === false || (int) $edad <= 0) {
            echo "<p>La edad introducida no es válida.</p>";
        } else if (!is_numeric($horas) || $horas <= 0) {
            echo "<p>Las horas semanales introducidas no son válidas.</p>";
        } else {

            $edad  = (int) $edad;
            $horas = (float) $horas;

            // Clasificación por edad
            if ($edad < 18) {
                $tipoAlumno = "Alumno menor de edad";
            } else if ($edad <= 30) {
                $tipoAlumno = "Alumno joven";
            } else {
                $tipoAlumno = "Alumno adulto";
            }

            // Clasificación por dedicación y recomendación
            if ($horas < 3) {
                $dedicacion    = "Baja";
                $recomendacion = "Te recomendamos comenzar por un curso de iniciación.";
            } else if ($horas <= 6) {
                $dedicacion    = "Media";
                $recomendacion = "Te recomendamos un curso de nivel intermedio.";
            } else {
                $dedicacion    = "Alta";
                $recomendacion = "Puedes realizar un curso avanzado.";
            }

            echo "<p>Nombre: $nombre $apellidos</p>";
            echo "<p>Curso: " . htmlspecialchars($curso) . "</p>";
            echo "<p>Edad: $edad</p>";
            echo "<p>Horas semanales: $horas</p>";
            echo "<p>Tipo de alumno: $tipoAlumno</p>";
            echo "<p>Dedicación: $dedicacion</p>";
            echo "<p>Recomendación:</p>";
            echo "<p><strong>$recomendacion</strong></p>";
        }

    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<p>Faltan datos en la matrícula.</p>";
    } else {
        echo "<p>No se ha realizado ninguna matrícula todavía.</p>";
    }

    ?>

</body>
</html>