<?php

namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';

use App\Atlas\config\Conexion;
use App\Atlas\controller\administradorController;
use App\Atlas\controller\notificacionController;

$conexion = new Conexion();
$admin = new administradorController();
$notificacion = new notificacionController();

$id= isset($_POST['id']) ? $conexion->limpiarCadena($_POST['id']) : "";
$usuario= isset($_POST['usuario']) ? $conexion->limpiarCadena($_POST['usuario']) : "";


switch ($_GET['modulo_datos']) {

    case 'datosUsuario':
        $admin->datosMasivosUsuario($usuario);
        break;



    default:
    case 'descargarBD':
        $admin->descargarBaseDatos();
        break;
        break;
}
