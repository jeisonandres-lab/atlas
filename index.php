<?php
session_start();

require_once './vendor/autoload.php';
use App\Atlas\config\App;
use App\Atlas\controller\viewController;
use App\Atlas\controller\userController;

$app = new App();
$login = new userController();
$viewsController = new viewController();

if (isset($_GET['vista'])) {
    $url = $_SERVER['REQUEST_URI']; // Obtener la URL completa
    $datosURL = $app->analizarURL($url);
    $vista = $datosURL['vista'];
    // print_r($url);
    $parametros = $datosURL['parametros'];
    if ($parametros == "") {
        $parametros = null;
    }
} else {
    $vista = "login";
}
$vista2 = $viewsController->obtenerVistasControlador($vista);
switch ($vista) {
    case 'Identificarse':
        require_once $vista2;
        break;
    default:
    if (isset($_SESSION['usuario'])) {
        // var_dump($_SESSION);
        $datosUser = $_SESSION['usuario'];
        $classActivo = $_SESSION['activado'] == '1' ? 'activado bg-success' : 'desactivado bg-danger';
        $act = $_SESSION['activado'] == '1' ? 'Activo' : 'Desactivado';
        $rol = $_SESSION['rol'];
        require_once $vista2;
    } else {
        header('location: Identificarse');
    }
        break;
}


