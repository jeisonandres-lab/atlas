<?php

namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';

use App\Atlas\config\Conexion;
use App\Atlas\controller\dependenciasController;
use App\Atlas\controller\cargoController;
use App\Atlas\controller\departamentoController;
use App\Atlas\controller\estatusController;

$conexion = new Conexion();
$dependencias = new dependenciasController();
$cargo = new cargoController();
$estatus = new estatusController();
$departamento = new departamentoController();

$id= isset($_POST['id']) ? $conexion->limpiarCadena($_POST['id']) : "";

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
    case 'editarDependencia':
        break;
    case 'editarCargo':
        break;
    case 'editarEstatus':
        break;
    case 'editarDepartamento':
        break;
    case 'eliminarDependencia':
        break;
    case 'eliminarCargo':
        break;
    case 'eliminarEstatus':
        break;
    case 'eliminarDepartamento':
        break;

    default:
        break;
}
