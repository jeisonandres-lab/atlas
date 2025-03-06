<?php

require_once '../../vendor/autoload.php';

require_once '../libs/fpdf/fpdf.php';

use App\Atlas\controller\report\imprimirPDFControllerLatter;
use App\Atlas\controller\report\imprimirPDFControllerLatterL;
use App\Atlas\controller\report\imprimirPDFControllerA4;
use App\Atlas\controller\report\imprimirPDFControllerA4L;
use App\Atlas\controller\report\fichaTecnicaController;
use App\Atlas\controller\notificacionController;
use App\Atlas\config\Conexion;
use App\Atlas\config\App;

$imprimirPDFController = new imprimirPDFControllerLatter();
$imprimirPDFControllerL = new imprimirPDFControllerLatterL();
$imprimirPDFControllerA4 = new imprimirPDFControllerA4();
$imprimirPDFControllerA4L = new imprimirPDFControllerA4L();
$fichaTecnicaController = new fichaTecnicaController();
$notificacion = new notificacionController();
$conexion = new Conexion();
$app = new App();

// require_once "../libs/fpdf/fpdf/fpdf.php";
$id = isset($_POST['id']) ? $conexion->limpiarCadena($_POST['id']) : "";
$cedula = isset($_POST['cedula']) ? $conexion->limpiarCadena($_POST['cedula']) : "";
$cargo = isset($_POST['cargo_filtrar']) ? $conexion->limpiarCadena($_POST['cargo_filtrar']) : "";
$sexo = isset($_POST['sexo_filtrar']) ? $conexion->limpiarCadena($_POST['sexo_filtrar']) : "";
$edad = isset($_POST['edad_filtrar']) ? $conexion->limpiarCadena($_POST['edad_filtrar']) : "";
$estatus = isset($_POST['estatus_filtrar']) ? $conexion->limpiarCadena($_POST['estatus_filtrar']) : "";
$estadoCivil = isset($_POST['civil_filtrar']) ? $conexion->limpiarCadena($_POST['civil_filtrar']) : "";
$vivienda = isset($_POST['vivienda_filtrar']) ? $conexion->limpiarCadena($_POST['vivienda_filtrar']) : "";
$nivelacademico = isset($_POST['nivelacademico_filtrar']) ? $conexion->limpiarCadena($_POST['nivelacademico_filtrar']) : "";

$estado = isset($_POST['estado_filtrar']) ? $conexion->limpiarCadena($_POST['estado_filtrar']) : "";
$municipio = isset($_POST['municipio_filtrar']) ? $conexion->limpiarCadena($_POST['municipio_filtrar']) : "";
$parroquia = isset($_POST['parroquia_filtrar']) ? $conexion->limpiarCadena($_POST['parroquia_filtrar']) : "";

$fechaing_filtrar = isset($_POST['fechaing_filtrar2']) ? $conexion->limpiarCadena($_POST['fechaing_filtrar2']) : "";
$fecha_ini = isset($_POST['fecha_ini_filtrar2']) ? $conexion->limpiarCadena($_POST['fecha_ini_filtrar2']) : "";
$fecha_fin = isset($_POST['fecha_fin_filtrar2']) ? $conexion->limpiarCadena($_POST['fecha_fin_filtrar2']) : "";

$dependencia = isset($_POST['dependencia_filtrar']) ? $conexion->limpiarCadena($_POST['dependencia_filtrar']) : "";
$departamento = isset($_POST['departamento_filtrar']) ? $conexion->limpiarCadena($_POST['departamento_filtrar']) : "";


switch ($_GET['accion']) {
    case 'imprimirDependencia':
        $imprimirPDFController->generarDependenciaPDF();
        break;
    case 'imprimirCargo':
        $imprimirPDFController->generarCargoPDF();
        break;
    case 'imprimirEstatus':
        $imprimirPDFController->generarEstatusPDF();
        break;
    case 'imprimirDepartamento':
        $imprimirPDFController->generarDepartamentoPDF();
        break;
    case 'impirimirEmpleados':
        $imprimirPDFControllerL->generarEmpleadoPDF();
        break;
    case 'fichaTecnica':
        $app->iniciarSession();
        $ficha = $fichaTecnicaController->generarFicha($cedula);
        $user = $_SESSION['usuario'];
        $iduser = $_SESSION['id'];
        $idUserDirec = 1;
        $enviarnotificacion = 'El usuario  ' . $user . ' a descagadola ficha tecnica del cedulado ' . $cedula;
        $notificacion->generarNotificacion($iduser, $idUserDirec, $enviarnotificacion);
        break;

    case 'impirimirAusencias':
        $imprimirPDFController->generarAusenciasPDF();
        break;

    case 'impirimirEmpleadosCargo':
        break;
    case 'impirimirEmpleadosSexo':
        break;
    case 'impirimirEmpleadosEdad':
        break;
    case 'impirimirEmpleadosCivil':
        break;
    case 'impirimirEmpleadosVivienda':
        break;
    case 'impirimirEmpleadosEstatus':
        break;
    case 'impirimirEmpleadosAcademico':
        break;
    case 'impirimirEmpleadosDireccion':
        break;
    case 'impirimirEmpleadosIngreso':
        break;
    case 'impirimirEmpleadosRangoFecha':
        break;
    case 'impirimirEmpleadosDependencia':
        break;
    case 'impirimirEmpleadosDepartamento':
        break;
    default:
        # code...
        break;
}
