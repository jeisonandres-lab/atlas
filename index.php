<?php
// Inicialmente NO iniciamos la sesión automáticamente

require_once './vendor/autoload.php';

use App\Atlas\config\App;
use App\Atlas\config\HoraLocal;
use App\Atlas\controller\ViewController;

$app = new App(); // Instancias de la clase App
$viewsController = new ViewController(); // Instancias de la clase viewController
$horaLocal = new HoraLocal(); // Instancia de la clase HoraLocal

// Obtener y procesar la URL
$vista = isset($_GET['vista']) ? $_GET['vista'] : 'login';
$url = $_SERVER['REQUEST_URI'];
$datosURL = $app->analizarURL($url);
$parametros = !empty($datosURL['parametros']) ? $datosURL['parametros'] : null;

// Array de rutas públicas que no requieren autenticaciónñ
$rutasPublicas = [
    'Identificarse',
    'recuperarDatos',
    'login',
    'horario'
];

// Obtener la vista correspondiente
$vista2 = $viewsController->obtenerVistasControlador($vista);

// Validar horario de acceso (6 AM a 5 PM)
$fechaHoraActual = $horaLocal->obtenerFechaHoraServidor();
$horaActual = date('H', strtotime($fechaHoraActual));

// Verificar si la hora actual está dentro del rango permitido (6 AM a 5 PM)
//if ($horaActual < 6 || $horaActual >= 17) {
    // Si está fuera del horario permitido, redirigir a la vista de horario
    //if ($vista !== 'horario') {
       // header('Location: horario');
     //   exit();
   // }
//}

// Verificar si la ruta actual es pública
if (in_array($vista, $rutasPublicas)) {
    require_once $vista2;
} else {
    // Solo iniciamos la sesión si estamos en una ruta protegida
    session_start();

    // Verificar autenticación para rutas protegidas
    if (isset($_SESSION['usuario'])) {
        $datosUser = $_SESSION['usuario'];
        $classActivo = $_SESSION['activado'] == '1' ? 'activado bg-success' : 'desactivado bg-danger';
        $act = $_SESSION['activado'] == '1' ? 'Activo' : 'Desactivado';
        $rol = $_SESSION['rol'];
        require_once $vista2;
    } else {
        // Si no hay sesión, redirigimos al login
        header('Location: Identificarse');
        exit();
    }
}
