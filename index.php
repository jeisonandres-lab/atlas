<?php

require_once './config/app.php';
require_once './config/sesion_start.php';
require_once './vendor/autoload.php';

error_reporting(E_ALL); // Informe de errores: informe todos los errores excepto los avisos

ini_set('ignore_repeated_errors', TRUE); // Ignorar errores repetidos: siempre use TRUE

ini_set('display_errors', FALSE); // Mostrar errores: use FALSE solo en entornos de producción o servidores reales. Use TRUE en entornos de desarrollo

ini_set('log_errors', TRUE); // Registrar errores en archivo: activar el registro de errores en un archivo

ini_set("error_log", "./php-error.log"); // Ruta del archivo de registro de errores: especificar la ruta del archivo donde se registrarán los errores

error_log("Hello, errors!"); // Registrar mensaje de error: registrar un mensaje de error personalizado


if (isset($_GET['views'])) {
    $url = explode("/", $_GET['views']);
} else {
    $url = ["login"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>