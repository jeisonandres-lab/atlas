<?php

require_once '../../vendor/autoload.php';

use App\Atlas\controller\estadistica\TotalEstadisticaController;
use App\Atlas\config\App;

App::zonaHoraria(); // Establece la zona horaria

// use App\Atlas\controller\notificacionController;

// $notificacion = new notificacionController();
$totalDatos = new TotalEstadisticaController();

switch ($_GET['modulo_Datos']) {
    case 'totalDatos':
        $totalDatos->totalDatosCard();
        break;

    case 'totalArchivosMes':
        $totalDatos->totalArchivosMes();
        break;

    case 'totalArchivosDia':
         $totalDatos->totalArchivosDia();
        break;


    default:
        # code...
        break;
}
