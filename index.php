<?php
// Inicialmente NO iniciamos la sesión automáticamente

require_once './vendor/autoload.php';

use App\Atlas\config\Aplicacion;

// Inicializar y ejecutar la aplicación
$application = new Aplicacion();
$application->run();