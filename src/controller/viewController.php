<?php

namespace App\Atlas\controller;

use App\Atlas\config\error;
use App\Atlas\models\viewModel;

class viewController extends viewModel
{

    /*---------- Controlador obtener vistas ----------*/
    public function obtenerVistasControlador(string $vista, string $query = null)
    {
        error::captureError();
        // Procesar parámetros GET
    if ($query) {
        parse_str($query, $params);
        // Utilizar los parámetros $params en tu lógica
        // Ejemplo:
        if (isset($params['usuario'])) {
            $usuario = $params['usuario'];
            // Hacer algo con el usuario
        }
    }
        if ($vista != "") {
            $respuesta = $this->obtenerVistasModelo($vista);
        } else {
            $respuesta = "Identificarse";
        }
        return $respuesta;
    }

}
