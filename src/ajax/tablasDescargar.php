<?php

require_once '../../vendor/autoload.php';

require_once '../libs/fpdf/fpdf.php';

use App\Atlas\controller\report\imprimirPDFControllerLatter;
use App\Atlas\controller\report\imprimirPDFControllerLatterL;
use App\Atlas\controller\report\imprimirPDFControllerA4;
use App\Atlas\controller\report\imprimirPDFControllerA4L;
use App\Atlas\controller\report\fichaTecnicaController;
use App\Atlas\controller\report\reportesController;
use App\Atlas\controller\report\generateExcelController;
use App\Atlas\controller\notificacionController;
use App\Atlas\config\Conexion;
use App\Atlas\config\App;

$imprimirPDFController = new imprimirPDFControllerLatter();
$imprimirPDFControllerL = new imprimirPDFControllerLatterL();
$imprimirPDFControllerA4 = new imprimirPDFControllerA4();
$imprimirPDFControllerA4L = new imprimirPDFControllerA4L();
$excelgenerator = new generateExcelController();
$fichaTecnicaController = new fichaTecnicaController();
$reportes = new reportesController();
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

$discapacidad = isset($_POST['tpDiscapacidad']) ? $conexion->limpiarCadena($_POST['tpDiscapacidad']) : "";
$parentesco = isset($_POST['parentesco']) ? $conexion->limpiarCadena($_POST['parentesco']) : "";

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
    case 'impirimirFamiliar':
        $imprimirPDFControllerL->generarFamiliarPDF();
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
        $reportes->generarPDFCargo($cargo);
        break;
    case 'impirimirEmpleadosSexo':
        $reportes->generarPDFSexo($sexo);
        break;
    case 'impirimirEmpleadosEdad':
        $reportes->generarPDFedad($edad);
        break;
    case 'impirimirEmpleadosCivil':
        $reportes->generarPDFestadoCivil($estadoCivil);
        break;
    case 'impirimirEmpleadosVivienda':
        $reportes->generarPDFvivienda($vivienda);
        break;
    case 'impirimirEmpleadosEstatus':
        $reportes->generarPDFEstatus($estatus);
        break;
    case 'impirimirEmpleadosAcademico':
        $reportes->generarPDFnivelAcademico($nivelacademico);
        break;
    case 'impirimirEmpleadosDireccion':
        $reportes->generarPDFdireccion($estado, $municipio, $parroquia);
        break;

    case 'impirimirEmpleadosRangoFecha':
        function convertirFecha($fecha)
        {
            // Crea un objeto DateTime a partir de la fecha en formato dd-mm-aaaa
            $fechaObj = DateTime::createFromFormat('d-m-Y', $fecha);

            // Si la fecha es válida, la formatea en aaaa-mm-dd
            if ($fechaObj) {
                return $fechaObj->format('Y-m-d');
            } else {
                // Si la fecha no es válida, devuelve false o lanza una excepción
                return false; // O: throw new Exception("Formato de fecha inválido: $fecha");
            }
        }
        $fecha_ini_convertida = convertirFecha($fecha_ini);
        $fecha_fin_convertida = convertirFecha($fecha_fin);
        $reportes->generarPDFrangoFhecha($fecha_ini_convertida,  $fecha_fin_convertida, $fecha_ini, $fecha_fin);
        break;
    case 'impirimirEmpleadosDependencia':
        $reportes->generarPDFdependencia($dependencia);
        break;
    case 'impirimirEmpleadosDepartamento':


        $reportes->generarPDFdepartamento($departamento);
        break;
    //REPORTES DE EXCEL
    case 'impirimirEmpleadosCargoExcel':
        $excelgenerator->generarExcelCargo($cargo);
        break;
    case 'impirimirEmpleadosSexoExcel':
        $excelgenerator->excelEmepleadoSexualidad($sexo);
        break;
    case 'impirimirEmpleadosEdadExcel':
        $excelgenerator->generarExceledad($edad);
        break;
    case 'impirimirEmpleadosCivilExcel':
        $excelgenerator->generarExcelestadoCivil($estadoCivil);
        break;
    case 'impirimirEmpleadosViviendaExcel':
        $excelgenerator->generarExcelvivienda($vivienda);
        break;
    case 'impirimirEmpleadosEstatusExcel':
        $excelgenerator->generarExcelEstatus($estatus);
        break;
    case 'impirimirEmpleadosAcademicoExcel':
        $excelgenerator->generarExcelnivelAcademico($nivelacademico);
        break;
    case 'impirimirEmpleadosDireccionExcel':
        $excelgenerator->generarExceldireccion($estado, $municipio, $parroquia);
        break;

    case 'impirimirEmpleadosRangoFechaExcel':
        function convertirFecha($fecha)
        {
            // Crea un objeto DateTime a partir de la fecha en formato dd-mm-aaaa
            $fechaObj = DateTime::createFromFormat('d-m-Y', $fecha);

            // Si la fecha es válida, la formatea en aaaa-mm-dd
            if ($fechaObj) {
                return $fechaObj->format('Y-m-d');
            } else {
                // Si la fecha no es válida, devuelve false o lanza una excepción
                return false; // O: throw new Exception("Formato de fecha inválido: $fecha");
            }
        }
        $fecha_ini_convertida = convertirFecha($fecha_ini);
        $fecha_fin_convertida = convertirFecha($fecha_fin);
        $excelgenerator->generarExcelrangoFhecha($fecha_ini_convertida,  $fecha_fin_convertida, $fecha_ini, $fecha_fin);
        break;
    case 'impirimirEmpleadosDependenciaExcel':
        $excelgenerator->generarExceldependencia($dependencia);
        break;
    case 'impirimirEmpleadosDepartamentoExcel':
        $excelgenerator->generarExceldepartamento($departamento);
        break;
    //REPORTES DE FAMILIAR
    case 'impirimirFamiliarSexo':
        $reportes->generarPDFSexoFamiliar($sexo);
        break;
    case 'impirimirFamiliarEdad':
        $reportes->generarPDFedadFamiliar($edad);
        break;
    case 'impirimirFamiliarParentesco':
        $reportes->generarPDFparentescoFamiliar($parentesco);
        break;
    case 'impirimirFamiliarDiscapacidad':
        $reportes->generarPDFdiscapacidadFamiliar($discapacidad);
        break;
    case 'impirimirFamiliarRangoFecha':
        function convertirFecha($fecha)
        {
            // Crea un objeto DateTime a partir de la fecha en formato dd-mm-aaaa
            $fechaObj = DateTime::createFromFormat('d-m-Y', $fecha);

            // Si la fecha es válida, la formatea en aaaa-mm-dd
            if ($fechaObj) {
                return $fechaObj->format('Y-m-d');
            } else {
                // Si la fecha no es válida, devuelve false o lanza una excepción
                return false; // O: throw new Exception("Formato de fecha inválido: $fecha");
            }
        }
        $fecha_ini_convertida = convertirFecha($fecha_ini);
        $fecha_fin_convertida = convertirFecha($fecha_fin);
        $reportes->generarPDFrangoFechaFamiliar($fecha_ini_convertida,  $fecha_fin_convertida, $fecha_ini, $fecha_fin);
        break;
    case 'impirimirFamiliarPersonalizado':
        function convertirFecha($fecha)
        {
            // Crea un objeto DateTime a partir de la fecha en formato dd-mm-aaaa
            $fechaObj = DateTime::createFromFormat('d-m-Y', $fecha);

            // Si la fecha es válida, la formatea en aaaa-mm-dd
            if ($fechaObj) {
                return $fechaObj->format('Y-m-d');
            } else {
                // Si la fecha no es válida, devuelve false o lanza una excepción
                return false; // O: throw new Exception("Formato de fecha inválido: $fecha");
            }
        }
        $fecha_ini_convertida = convertirFecha($fecha_ini);
        $fecha_fin_convertida = convertirFecha($fecha_fin);
        $reportes->generarPDFrangoFechaFamiliar($fecha_ini_convertida,  $fecha_fin_convertida, $fecha_ini, $fecha_fin, $discapacidad, $parentesco, $sexo, $edad);
        break;
    //REPORTE FAMILIAR EXCEL
    case 'impirimirFamiliarSexoExcel':
        $excelgenerator->excelFamiliarSexualidad($sexo);
        break;
    case 'impirimirFamiliarEdadExcel':
        $excelgenerator->excelFamiliarEdad($edad);
        break;
    case 'impirimirFamiliarDiscapacidadExcel':
        $excelgenerator->excelFamiliarDiscapacidad($discapacidad);
        break;
    case 'impirimirFamiliarParentescoExcel':
        $excelgenerator->excelFamiliarParentesco($parentesco);
        break;
    case 'impirimirFamiliarRangoFechaExcel':
        function convertirFecha($fecha)
        {
            // Crea un objeto DateTime a partir de la fecha en formato dd-mm-aaaa
            $fechaObj = DateTime::createFromFormat('d-m-Y', $fecha);

            // Si la fecha es válida, la formatea en aaaa-mm-dd
            if ($fechaObj) {
                return $fechaObj->format('Y-m-d');
            } else {
                // Si la fecha no es válida, devuelve false o lanza una excepción
                return false; // O: throw new Exception("Formato de fecha inválido: $fecha");
            }
        }
        $fecha_ini_convertida = convertirFecha($fecha_ini);
        $fecha_fin_convertida = convertirFecha($fecha_fin);
        $excelgenerator->excelFamiliarRangoFecha($fecha_ini_convertida,  $fecha_fin_convertida, $fecha_ini, $fecha_fin);
        break;
    case 'imprimirFamiliarPersonalizadoExcel':
        # code...
        break;
    default:
        # code...
        break;
}
