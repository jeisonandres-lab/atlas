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
use App\Atlas\config\peticiones;
use App\Atlas\controller\familiarController;
$conexion = new conexion();
$dependencias = new dependenciasController();
$estatus = new estatusController();
$cargo = new cargoController();
$departamento = new departamentoController();
$personal = new personalController(true);
$notificacion = new notificacionController();
$ubicacion = new ubicacionController();
$peticionHandler = new peticiones();
$familiar = new familiarController();

// variables estraidas
$variables = $peticionHandler->obtenerVariables();
extract($variables);

$FamiliarInces= isset($_POST['FamiliarInces']) ? $conexion->limpiarCadena($_POST['FamiliarInces']) : "";
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
            $edad,

            $discapacidad,
            $FamiliarInces,
            $primerNombreFamiliar,
            $primerApellidoFamiliar,
            $cedulaFamiliar,
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
    case 'obtenerDatosFamiliarTotal':
            $personal->obtenerFamiliarTotal();
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

        $FamiliarInces = '1';
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
            $folio,
            $discapacidad,
            $sexo,
            $familiarInces
        );
        break;
    case 'obtenerPersonal':
        $personal->obtenerTodoPersonal();
        break;
    case 'obtenerFamiliar':
        $personal->obtenerFamiliar($idPersonal);
        break;
    case 'buscarFamiliarPendiente':
        $familiar->buscarFamilairPendiente($cedulaFamiliar);
        break;
    case 'eliminarPersonal':
        $personal->eliminarEmpleado($idPersonal);
        break;
    case 'eliminarFamiliar':
        $personal->eliminarFamiliar($idPersonal);
        break;
    case 'actualizarPersonal':
        $telefono = $linea . "-" . $telefono;
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
            $fechaING,
            $discapacidad,
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
            $folio,
            $sexo,
            $discapacidad
        );
        break;
    case 'obtenerDataEmpleados':
        $personal->obtenerTodaDataEmpleado($cedulaFamiliar);
        break;
    default:

        # code...
        break;
}
