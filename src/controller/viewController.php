<?php

namespace App\Atlas\controller;

use App\Atlas\config\error;
use App\Atlas\models\viewModel;

class viewController extends viewModel
{

    /*---------- Controlador obtener vistas ----------*/
    public function obtenerVistasControlador(string $vista)
    {
        error::captureError();
        if ($vista != "") {
            $respuesta = $this->obtenerVistasModelo($vista);
        } else {
            $respuesta = "logear";
        }
        return $respuesta;
    }
}
