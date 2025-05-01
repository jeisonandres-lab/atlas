<?php

namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';

use App\Atlas\config\Conexion;
use App\Atlas\controller\vacacionesController;
use App\Atlas\controller\notificacionController;

$conexion = new Conexion();
$vacaciones = new vacacionesController();
$notificacion = new notificacionController();

$id = isset($_POST['id']) ? $conexion->limpiarCadena($_POST['id']) : "";
$activo = isset($_POST['activo']) ? $conexion->limpiarCadena($_POST['activo']) : "";
$cedula = isset($_POST['cedula']) ? $conexion->limpiarCadena($_POST['cedula']) : "";

$fecha_ini = isset($_POST['fecha_ini']) ? $conexion->limpiarCadena($_POST['fecha_ini']) : "";
$fecha_fin = isset($_POST['fecha_fin']) ? $conexion->limpiarCadena($_POST['fecha_fin']) : "";

$ano = isset($_POST['ano']) ? $conexion->limpiarCadena($_POST['ano']) : "";
$dias = isset($_POST['dias']) ? $_POST['dias'] : "";
$diadisfrute = isset($_POST['diadisfrute']) ? $_POST['diadisfrute'] : "";


$permiso = isset($_POST['permiso']) ? $conexion->limpiarCadena($_POST['permiso']) : "";

$primerNombre = isset($_POST['primerNombre']) ? $conexion->limpiarCadena($_POST['primerNombre']) : "";
$primerApellido = isset($_POST['primerApellido']) ? $conexion->limpiarCadena($_POST['primerApellido']) : "";
date_default_timezone_set("America/Caracas");

switch ($_GET['modulo_datos']) {
    case 'registrarAusencia':
        $vacaciones->registrarAusencia($cedula, $id, $fecha_ini, $fecha_fin, $primerNombre, $primerApellido, $permiso);
        break;
    case 'todasAusencias':
        $vacaciones->todasAusencias();
        break;
    case 'buscarDatosAusencia':
        $vacaciones->datosEmpleadoAusencia($id);
        break;
    case 'actualizarAusencia':
        $vacaciones->actualizarAusencia($cedula, $id, $fecha_ini, $fecha_fin, $permiso, $primerNombre, $primerApellido);
        break;

    case 'liberarAusencia':
        $vacaciones->liberarAusencia($id);
        break;
    case 'registrarVacaciones':
        $vacaciones->registrarVacaciones($id, $cedula, $ano, $dias);
        break;
    case 'todasVacaciones':
        $vacaciones->datosVacaciones2();
        break;
    case 'actualizarVacaciones':
        $vacaciones->actualizarVacaciones($id, $cedula, $ano, $dias, $diadisfrute);
        break;
    case 'desactivarVaca':
        $vacaciones->eliminarVacaciones($id);
        break;
    default:
        break;
}
