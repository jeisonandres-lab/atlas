<?php

namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';

use App\Atlas\controller\totalDateController;

$totalDatos = new totalDateController();

switch ($_GET['modulo_Datos']) {
    case 'totalDatos':
        $totalDatos->totalDatosCard();
        break;

    case 'totalArchivosMes':
        sleep(2);
        $totalDatos->totalArchivosMes();
        break;

    case 'totalArchivosDia':
        sleep(1);
        $totalDatos->totalArchivosDia();
        break;


    default:
        # code...
        break;
}
