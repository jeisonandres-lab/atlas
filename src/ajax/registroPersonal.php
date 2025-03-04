<?php

namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';

use App\Atlas\config\Conexion;
use App\Atlas\controller\personalController;
use App\Atlas\controller\dependenciasController;
use App\Atlas\controller\cargoController;
use App\Atlas\controller\departamentoController;
use App\Atlas\controller\estatusController;
use App\Atlas\controller\notificacionController;
use App\Atlas\controller\ubicacionController;

$conexion = new conexion();
$dependencias = new dependenciasController();
$estatus = new estatusController();
$cargo = new cargoController();
$departamento = new departamentoController();
$personal = new personalController();
$notificacion = new notificacionController();
$ubicacion = new ubicacionController();

// DATOS PARA REGISTRAR DATOS PERSONAL
$primerNombre = isset($_POST['primerNombre']) ? $conexion->limpiarCadena($_POST['primerNombre']) : "";
$segundoNombre = isset($_POST['segundoNombre']) ? $conexion->limpiarCadena($_POST['segundoNombre']) : "";
$primerApellido = isset($_POST['primerApellido']) ? $conexion->limpiarCadena($_POST['primerApellido']) : "";
$segundoApellido = isset($_POST['segundoApellido']) ? $conexion->limpiarCadena($_POST['segundoApellido']) : "";
$parentesco = isset($_POST['parentesco']) ? $conexion->limpiarCadena($_POST['parentesco']) : "";
$cedula = isset($_POST['cedula']) ? $conexion->limpiarCadena($_POST['cedula']) : "";
$cedulaEmpleado = isset($_POST['cedulaEmpleado']) ? $conexion->limpiarCadena($_POST['cedulaEmpleado']) : "";
$civil = isset($_POST['civil']) ? $conexion->limpiarCadena($_POST['civil']) : "";
$correo = isset($_POST['correo']) ? $conexion->limpiarCadena($_POST['correo']) : "";
$ano = isset($_POST['ano']) ? $conexion->limpiarCadena($_POST['ano']) : "";
$mes = isset($_POST['meses']) ? $_POST['meses'] : "";
$dia = isset($_POST['dia']) ? $conexion->limpiarCadena($_POST['dia']) : "";
$edad = isset($_POST['edad']) ? $conexion->limpiarCadena($_POST['edad']) : "";
$sexo = isset($_POST['sexo']) ? $conexion->limpiarCadena($_POST['sexo']) : "";
$nivelAcademico = isset($_POST['nivelAcademico']) ? $conexion->limpiarCadena($_POST['nivelAcademico']) : "";

// DATOS PARA REGISTRAR EMPELADO
$idPersonal = isset($_POST['id']) ? $conexion->limpiarCadena($_POST['id']) : "";
$idPersonal2 = isset($_POST['idPersonal']) ? $conexion->limpiarCadena($_POST['idPersonal']) : "";
$idEmpleado = isset($_POST['idEmpleado']) ? $conexion->limpiarCadena($_POST['idEmpleado']) : "";
$fechaING = isset($_POST['fechaing']) ? $conexion->limpiarCadena($_POST['fechaing']) : "";


$idfamiliar = isset($_POST['idfamiliar']) ? $conexion->limpiarCadena($_POST['idfamiliar']) : "";
$telefono = isset($_POST['telefono']) ? $conexion->limpiarCadena($_POST['telefono']) : "";
$linea = isset($_POST['linea']) ? $conexion->limpiarCadena($_POST['linea']) : "";
$idEstatus = isset($_POST['estatus']) ? $conexion->limpiarCadena($_POST['estatus']) : "";
$idCargo = isset($_POST['cargo']) ? $conexion->limpiarCadena($_POST['cargo']) : "";
$idDepartamento = isset($_POST['departamento']) ? $conexion->limpiarCadena($_POST['departamento']) : "";
$idDependencia = isset($_POST['dependencia']) ? $conexion->limpiarCadena($_POST['dependencia']) : "";
$numeroCarnet = isset($_POST['carnet']) ? $conexion->limpiarCadena($_POST['carnet']) : "";
$tomo = isset($_POST['tomo']) ? $conexion->limpiarCadena($_POST['tomo']) : "";
$folio = isset($_POST['folio']) ? $conexion->limpiarCadena($_POST['folio']) : "";

//ubicaciones
$idestado = isset($_POST['estado']) ? $conexion->limpiarCadena($_POST['estado']) : "";
$idestado2 = isset($_POST['idestado']) ? $conexion->limpiarCadena($_POST['idestado']) : "";
$idMunicipio = isset($_POST['municipio']) ? $conexion->limpiarCadena($_POST['municipio']) : "";
$idMunicipio2 = isset($_POST['idmunicipio']) ? $conexion->limpiarCadena($_POST['idmunicipio']) : "";
$idParroquia = isset($_POST['parroquia']) ? $conexion->limpiarCadena($_POST['parroquia']) : "";
$vivienda = isset($_POST['vivienda']) ? $conexion->limpiarCadena($_POST['vivienda']) : "";
$calle = isset($_POST['calle']) ? $conexion->limpiarCadena($_POST['calle']) : "";
$numeroVivienda = isset($_POST['numeroVivienda']) ? $conexion->limpiarCadena($_POST['numeroVivienda']) : "";

$pisoUrba= isset($_POST['piso']) ? $conexion->limpiarCadena($_POST['piso']) : "";
$nombreUrba = isset($_POST['urbanizacion']) ? $conexion->limpiarCadena($_POST['urbanizacion']) : "";
$numeroDepa = isset($_POST['numeroDepa']) ? $conexion->limpiarCadena($_POST['numeroDepa']) : "";

switch ($_GET['modulo_personal']) {
    case 'registrar':
        $telefono = $linea . "-" . $telefono;
        $personal->registro(
            $primerNombre,
            $segundoNombre,
            $primerApellido,
            $segundoApellido,
            $cedula,
            $civil,
            $correo,
            $ano,
            $mes,
            $dia,
            $idEstatus,
            $idCargo,
            $idDependencia,
            $idDepartamento,
            $telefono,
            $nivelAcademico,
            $vivienda,
            $sexo,
            $idestado,
            $idMunicipio,
            $idParroquia,
            $calle,
            $numeroVivienda,
            $pisoUrba,
            $nombreUrba,
            $numeroDepa,
            $fechaING,
            $edad
        );
        break;
    case 'obtenerDependencias':
        $dependencias->obtenerdependeciasGeneral();
        break;
    case 'obtenerEstatus':
        $estatus->obtenerEstatusGeneral();
        break;
    case 'obtenerCargo':
        $cargo->obtenerCargoGeneral();
        break;
    case 'obtenerDepartamento':
        $departamento->obtenerDeparmatentoGeneral();
        break;
    case 'obtenerDatosPersonal':
        $personal->obtenerDatosPersonal($cedulaEmpleado);
        break;

    case 'obtenerDatosFamiliar':
        $personal->obtenerDatosFamiliar($idPersonal);
        break;
    case 'obtenerEstados':
        $ubicacion->obtenerEstados();
        break;
    case 'obtenerMunicipio':
        $ubicacion->obtenerMunicipio($idestado2);
        break;
    case 'obtenerParroquia':
        $ubicacion->obtenerParroquia($idMunicipio2);
        break;
    case 'registrarFamilia':
        $personal->registrarFamilia(
            $parentesco,
            $cedulaEmpleado,
            $primerNombre,
            $segundoNombre,
            $primerApellido,
            $segundoApellido,
            $cedula,
            $edad,
            $ano,
            $mes,
            $dia,
            $numeroCarnet,
            $tomo,
            $folio
        );
        break;
    case 'obtenerPersonal':
        $personal->obtenerTodoPersonal();
        break;
    case 'obtenerFamiliar':
        $personal->obtenerFamiliar($idPersonal);
        break;
    case 'eliminarPersonal':
        $personal->eliminarEmpleado($idPersonal);
        break;
    case 'eliminarFamiliar':
        $personal->eliminarFamiliar($idPersonal);
        break;
    case 'actualizarPersonal':
        $personal->actualizarPersonal(
            $idPersonal,
            $idEmpleado,
            $primerNombre,
            $segundoNombre,
            $primerApellido,
            $segundoApellido,
            $cedula,
            $civil,
            $correo,
            $ano,
            $mes,
            $dia,
            $idEstatus,
            $idCargo,
            $idDependencia,
            $idDepartamento,
            $telefono,
            $nivelAcademico,
            $vivienda,
            $sexo,
            $idestado,
            $idMunicipio,
            $idParroquia,
            $calle,
            $numeroVivienda,
            $pisoUrba,
            $nombreUrba,
            $numeroDepa,
            $fechaING
        );
        break;
    case 'actualizarFamiliar':
        $personal->actualizarFamiliar(
            $idPersonal,
            $idfamiliar,
            $parentesco,
            $cedulaEmpleado,
            $primerNombre,
            $segundoNombre,
            $primerApellido,
            $segundoApellido,
            $cedula,
            $edad,
            $ano,
            $mes,
            $dia,
            $numeroCarnet,
            $tomo,
            $folio
        );
        break;
    default:

        # code...
        break;
}
