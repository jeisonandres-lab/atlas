<?php
require_once '../../vendor/autoload.php';

require_once '../libs/fpdf/fpdf.php';

use App\Atlas\controller\report\imprimirPDFControllerLatter;
use App\Atlas\controller\report\imprimirPDFControllerLatterL;
use App\Atlas\controller\report\imprimirPDFControllerA4;
use App\Atlas\controller\report\imprimirPDFControllerA4L;
use App\Atlas\controller\report\fichaTecnicaController;

$imprimirPDFController = new imprimirPDFControllerLatter();
$imprimirPDFControllerL = new imprimirPDFControllerLatterL();
$imprimirPDFControllerA4 = new imprimirPDFControllerA4();
$imprimirPDFControllerA4L = new imprimirPDFControllerA4L();
$fichaTecnicaController = new fichaTecnicaController();

// require_once "../libs/fpdf/fpdf/fpdf.php";
$id = isset($_POST['id']) ? $conexion->limpiarCadena($_POST['id']) : "";
$cedula = isset($_POST['cedula']) ? $conexion->limpiarCadena($_POST['cedula']) : "";

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
        $fichaTecnicaController->generarFicha($cedula);
        break;

    default:
        # code...
        break;
}
