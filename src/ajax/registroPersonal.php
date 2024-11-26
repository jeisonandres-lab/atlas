<?php

namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';

use App\Atlas\config\Conexion;
use App\Atlas\controller\personalController;
use App\Atlas\models\dependenciasModel;
use App\Atlas\models\estatusModel;

$conexion = new conexion();
$dependencias = new dependenciasModel();
$estatus = new estatusModel();
$personal = new personalController();

// DATOS PARA REGISTRAR DATOS PERSONAL
$primerNombre = isset($_POST['primerNombre']) ? $conexion->limpiarCadena($_POST['primerNombre']) : "";
$segundoNombre = isset($_POST['segundoNombre']) ? $conexion->limpiarCadena($_POST['segundoNombre']) : "";
$primerApellido = isset($_POST['primerApellido']) ? $conexion->limpiarCadena($_POST['primerApellido']) : "";
$segundoApellido = isset($_POST['segundoApellido']) ? $conexion->limpiarCadena($_POST['segundoApellido']) : "";
$cedula = isset($_POST['cedula']) ? $conexion->limpiarCadena($_POST['cedula']) : "";
$civil = isset($_POST['civil']) ? $conexion->limpiarCadena($_POST['civil']) : "";
$correo = isset($_POST['correo']) ? $conexion->limpiarCadena($_POST['correo']) : "";
$ano = isset($_POST['ano']) ? $conexion->limpiarCadena($_POST['ano']) : "";
$mes = isset($_POST['meses']) ? $_POST['meses'] : "";
$dia = isset($_POST['dia']) ? $conexion->limpiarCadena($_POST['dia']) : "";

// DATOS PARA REGISTRAR EMPELADO
$idPersonal = isset($_POST['id']) ? $conexion->limpiarCadena($_POST['id']) : "";
$telefono = isset($_POST['telefono']) ? $conexion->limpiarCadena($_POST['telefono']) : "";
$idEstatus = isset($_POST['estatus']) ? $conexion->limpiarCadena($_POST['estatus']) : "";
$idCargo = isset($_POST['cargo']) ? $conexion->limpiarCadena($_POST['cargo']) : "";
$idDepartamento = isset($_POST['departamento']) ? $conexion->limpiarCadena($_POST['departamento']) : "";
$idDependencia = isset($_POST['dependencia']) ? $conexion->limpiarCadena($_POST['dependencia']) : "";

switch ($_GET['modulo_personal']) {
    case 'registrar':
        $personal->registro($primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $cedula, $civil, $correo, $ano, $mes, $dia, $idEstatus, $idCargo, $idDependencia, $idDepartamento, $telefono);
        break;
    case 'obtenerDependencias':
        $personal->obtenerDependencias();
        break;
    case 'obtenerEstatus':
        $personal->obtenerEstatus();
        break;
    case 'obtenerCargo':
        $personal->obtenerCargo();
        break;

    case 'obtenerDepartamento':
        $personal->obtenerDepartamento();
        break;
    case 'obtenerDatosPersonal':
        $personal->obtenerDatosPersonal($cedula);
        break;
    default:
        # code...
        break;
}
