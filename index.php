<?php
// Inicialmente NO iniciamos la sesión automáticamente

require_once './vendor/autoload.php';
use App\Atlas\config\App;
use App\Atlas\controller\viewController;
use App\Atlas\controller\userController;

$app = new App();
$login = new userController();
$viewsController = new viewController();

// Obtener y procesar la URL
$vista = isset($_GET['vista']) ? $_GET['vista'] : 'login';
$url = $_SERVER['REQUEST_URI'];
$datosURL = $app->analizarURL($url);
$parametros = !empty($datosURL['parametros']) ? $datosURL['parametros'] : null;

// Array de rutas públicas que no requieren autenticación
$rutasPublicas = [
    'Identificarse',
    'recuperarDatos',
    'login'
];

// Obtener la vista correspondiente
$vista2 = $viewsController->obtenerVistasControlador($vista);

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
?>