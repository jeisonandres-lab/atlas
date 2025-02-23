<?php

namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';

use App\Atlas\config\Conexion;
use App\Atlas\controller\notificacionController;
use App\Atlas\config\App;

$conexion = new Conexion();
$notificacion = new notificacionController();
$app = new App();

$cedula = isset($_POST['cedula']) ? $conexion->limpiarCadena($_POST['cedula']) : "";


switch ($_GET['modulo_noti']) {

    case 'obtenerNoti':
        $app->iniciarSession();
        $idRol = $_SESSION['idrol'];
        $notificacion->obtenerNotificacion($idRol);
        break;

    default:
        break;
}
