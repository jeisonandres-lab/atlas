<?php

namespace App\Atlas\controller\report;

use App\Atlas\models\dependenciasModel;
use App\Atlas\models\cargoModel;
use App\Atlas\models\estatusModel;
use App\Atlas\models\departamentoModel;
use App\Atlas\models\personalModel;
use App\Atlas\controller\report\pdfController; // Importa la clase pdfController

date_default_timezone_set("America/Caracas");

class imprimirPDFControllerA4L
{
    private $dependenciasData;
    private $cargoData;
    private $estatusData;
    private $departamentoData;
    private $personalData;
    private $pdf;

    public function __construct($orientation = 'L', $unit = 'mm', $size = 'A4')
    {
        $this->dependenciasData = new dependenciasModel();
        $this->pdf = new pdfController($orientation, $unit, $size); // Crear una instancia de pdfController con los parámetros
        $this->cargoData = new cargoModel();
        $this->estatusData = new estatusModel();
        $this->departamentoData = new departamentoModel();
        $this->personalData = new personalModel();
    }

}
