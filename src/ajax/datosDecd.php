<?php

namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';

use App\Atlas\config\Conexion;
use App\Atlas\controller\dependenciasController;
use App\Atlas\controller\cargoController;
use App\Atlas\controller\departamentoController;
use App\Atlas\controller\estatusController;
use App\Atlas\controller\notificacionController;

$conexion = new Conexion();
$dependencias = new dependenciasController();
$cargo = new cargoController();
$estatus = new estatusController();
$departamento = new departamentoController();
$notificacion = new notificacionController();

$id= isset($_POST['id']) ? $conexion->limpiarCadena($_POST['id']) : "";
$activo = isset($_POST['activo']) ? $conexion->limpiarCadena($_POST['activo']) : "";

//DATOS DE DEPENDENCIA
$nombredepen = isset($_POST['dependencia']) ? $conexion->limpiarCadena($_POST['dependencia']) : "";
$codigodepen = isset($_POST['codigo']) ? $conexion->limpiarCadena($_POST['codigo']) : "";
$estadodepen = isset($_POST['estado']) ? $conexion->limpiarCadena($_POST['estado']) : "";

//DATOS DE CARGO
$nombreCargo = isset($_POST['cargo']) ? $conexion->limpiarCadena($_POST['cargo']) : "";

//DATOS DE ESTATUS

$nombreEstatus = isset($_POST['estatus']) ? $conexion->limpiarCadena($_POST['estatus']) : "";

//DATOS DE DEPARTAMENTO
$nombreDepartamento = isset($_POST['departamento']) ? $conexion->limpiarCadena($_POST['departamento']) : "";

switch ($_GET['modulo_datos']) {
    case 'obtenerDatosDepe':
        $dependencias->datosDependencia();
        break;
    case 'obtenerDatosCargo':
        $cargo->datosCargo();
        break;
    case 'obtenerDatosEstatus':
        $estatus->datosEstatus();
        break;
    case 'obtenerDatosDepartamento':
        $departamento->datosDepartamento();
        break;
    case 'obtenerEstados':
        $dependencias->datosEstado();
        break;
    case 'agregarDependencia':
        $dependencias->regisDependencia($nombredepen, $codigodepen, $estadodepen);
        break;
    case 'agregarEstatus':
        $estatus->regisEstatus($nombreEstatus);
        break;
    case 'agregarCargo':
        $cargo->regisCargo($nombreCargo);
        break;
    case 'agregarDepartamento':
        $departamento->regisDepartamento($nombreDepartamento);
        break;
    case 'obtenerDependencia':
        $dependencias->dependencia($id);
        break;
    case 'editarDependencia':
        $dependencias->editarDependencia($id, $nombredepen, $codigodepen, $estadodepen);
        break;
    case 'editarCargo':
        $cargo->editarCargo($id, $nombreCargo);
        break;
    case 'editarEstatus':
        $estatus->editarEstatus($id, $nombreEstatus);
        break;
    case 'editarDepartamento':
        $departamento->editarDepartamento($id, $nombreDepartamento);
        break;
    case 'eliminarActivarDependencia':
        $dependencias->eliminarActivarDependencia($id, $activo);
        break;
    case 'eliminarActivarCargo':
        $cargo->eliminarActivarCargo($id, $activo);
        break;
    case 'eliminarActivarEstatus':
        $estatus->eliminarActivarEstatus($id, $activo);
        break;
    case 'eliminarActivarDepartamento':
        $departamento->eliminarActivarDepartamento($id, $activo);
        break;

    default:
        break;
}
