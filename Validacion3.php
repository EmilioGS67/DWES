<?php

$mensajeUrl = '';
$mensajeIp  = '';
$url = '';
$ip  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $url = isset($_POST['url']) ? trim($_POST['url']) : '';
    $ip  = isset($_POST['ip'])  ? trim($_POST['ip'])  : '';

    if ($url === '') {
        $mensajeUrl = "La URL está vacía.";
    } else if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        $mensajeUrl = "URL no válida.";
    } else {

        $esquema = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        if ($esquema === 'http' || $esquema === 'https') {
            $mensajeUrl = "URL correcta.";
        } else {
            $mensajeUrl = "URL no válida: solo se admiten http y https.";
        }
    }

    if ($ip === '') {
        $mensajeIp = "La IP está vacía.";
    } else if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
        $mensajeIp = "Dirección IP no válida.";
    } else if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
        $mensajeIp = "Dirección IP correcta (IPv4).";
    } else {
        $mensajeIp = "Dirección IP correcta (IPv6).";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validación A3</title>
</head>
<body>

    <h1>A3. Validar URL e IP</h1>

    <form action="" method="POST">
        <label for="url">URL:</label>
        <input type="text" id="url" name="url" size="40" value="<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>">
        <br><br>

        <label for="ip">Dirección IP:</label>
        <input type="text" id="ip" name="ip" size="40" value="<?php echo htmlspecialchars($ip, ENT_QUOTES, 'UTF-8'); ?>">
        <br><br>

        <button type="submit">Validar</button>
    </form>

    <hr>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<p>URL: <strong>" . htmlspecialchars($mensajeUrl, ENT_QUOTES, 'UTF-8') . "</strong></p>";
        echo "<p>IP: <strong>" . htmlspecialchars($mensajeIp, ENT_QUOTES, 'UTF-8') . "</strong></p>";
    } else {
        echo "<p>Rellena los dos campos y pulsa Validar.</p>";
    }
    ?>

    <p>Pruebas sugeridas: https://www.ejemplo.es (sí), www.ejemplo.es (no), ftp://ejemplo.es (no por esquema),
       192.168.1.1 (sí), 256.1.1.1 (no), ::1 (sí, IPv6), 2001:db8::ff00:42:8329 (sí, IPv6).</p>

</body>
</html>
