<?php

namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';

use App\Atlas\config\Conexion;
use App\Atlas\controller\administradorController;
use App\Atlas\controller\notificacionController;
use App\Atlas\config\HoraLocal;

$conexion = new Conexion();

$admin = new administradorController();
$admin2 = new administradorController();
$notificacion = new notificacionController();
$horaLocal = new HoraLocal();

// $id = isset($_POST['id']) ? $conexion->limpiarCadena($_POST['id']) : "";
// $usuario = isset($_POST['usuario']) ? $conexion->limpiarCadena($_POST['usuario']) : "";
$cedula = isset($_POST['cedula']) ? $conexion->limpiarCadena($_POST['cedula']) : "";


switch ($_GET['modulo_datos']) {

    case 'datosUsuario':
        $admin->datosMasivosUsuario($usuario);
        break;

    case 'descargarBD':
        $admin->descargarBaseDatos();
        break;

    case 'existeCedula':
        $admin2->existeEmpleado($cedula);
        break;
    case 'HLServidor':
        $horaLocal->obtenerFechaHoraServidor();
        $datos = [
            'timestamp' => $horaLocal->obtenerTimestamp(),
            'fecha_formateada' => $horaLocal->obtenerFechaFormateada(),
            'hora_formateada' => $horaLocal->obtenerHoraFormateada(),
            'fecha_formateada_ingles' => $horaLocal->obtenerFechaFormateadaIngles(),
            'fecha_formateada_esp' => $horaLocal->obtenerFechaFormateadaEsp(),
        ];
        // header('Content-Type: application/json');
        echo json_encode($datos);
        break;

    default:
}
