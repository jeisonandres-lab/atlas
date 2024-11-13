<?php
require_once './vendor/autoload.php';

use App\Atlas\config\App;
use App\Atlas\controller\viewController;
use App\Atlas\controller\userController;

use App\Atlas\models\edModel;

$login = new userController();
$viewsController = new viewController();
$app= new App();
$ed = new edModel();
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


        $para = 'juan';
        $ed->encriptar($para);
        // if(isset($_SESSION) && isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])){
        //     $datosUser = $parametros['usuario'];
        //     $classActivo = $parametros['activado'] == 'activado' ? 'activado bg-success' : 'desactivado bg-danger';
        //     $act = $parametros['activado'] == 'activado' ? 'Activo' : 'Desactivado';
        //     require_once $vista2;
        // }else{
        //     header('location: Identificarse');
        // }
    break;
}

 require_once App::URL_INC."/scrips.php";
?>