<?php

namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';

use App\Atlas\config\Conexion;
use App\Atlas\controller\vacacionesController;
use App\Atlas\controller\notificacionController;

$conexion = new Conexion();
$vacaciones = new vacacionesController();
$notificacion = new notificacionController();

$id= isset($_POST['id']) ? $conexion->limpiarCadena($_POST['id']) : "";
$activo = isset($_POST['activo']) ? $conexion->limpiarCadena($_POST['activo']) : "";
$cedula = isset($_POST['cedula']) ? $conexion->limpiarCadena($_POST['cedula']) : "";

$fecha_ini = isset($_POST['fecha_ini']) ? $conexion->limpiarCadena($_POST['fecha_ini']) : "";
$fecha_fin = isset($_POST['fecha_fin']) ? $conexion->limpiarCadena($_POST['fecha_fin']) : "";

$permiso = isset($_POST['permiso']) ? $conexion->limpiarCadena($_POST['permiso']) : "";

date_default_timezone_set("America/Caracas");

switch ($_GET['modulo_datos']) {
    case 'registrarAusencia':
        $vacaciones->registrarAusencia($cedula, $id, $fecha_ini, $fecha_fin);
        break;
    case '':

    case '':

        break;
    case '':

        break;


    default:
        break;
}
