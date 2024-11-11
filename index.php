<?php
require_once './vendor/autoload.php';

use App\Atlas\config\App;
use App\Atlas\controller\viewController;
use App\Atlas\controller\userController;


$login = new userController();
$viewsController = new viewController();
$app= new App();

if (isset($_GET['vista'])) {
    $url = $_SERVER['REQUEST_URI']; // Obtener la URL completa
    $datosURL =$app->analizarURL($url);
    $vista = $datosURL['vista'];
    $parametros = $datosURL['parametros'];
    if ($parametros == "") {
        $parametros = null;
    }
} else {
    $vista = "login";
}
$vista2 = $viewsController->obtenerVistasControlador( $vista);
switch ($vista) {
    case 'Identificarse':
        require_once $vista2;
    break;
    default:
        $app->inicioSession($parametros);
        require_once $vista2;
        require_once "./src/views/inc/menu.php";
    break;
}

 require_once App::URL_INC."/scrips.php";
?>