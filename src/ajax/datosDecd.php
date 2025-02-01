<?php

namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';

use App\Atlas\config\Conexion;
use App\Atlas\controller\dependenciasController;
use App\Atlas\controller\cargoController;
use App\Atlas\controller\departamentoController;
use App\Atlas\controller\estatusController;

$dependencias = new dependenciasController();
$cargo = new cargoController();
$estatus = new estatusController();
$departamento = new departamentoController();

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
    default:
        break;
}
