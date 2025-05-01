<?php

namespace App\Atlas\controller\sistema;

use App\Atlas\config\Error;
use App\Atlas\models\private\ViewModel;

class ViewController extends ViewModel
{

    /*---------- Controlador obtener vistas ----------*/
    public function obtenerVistasControlador(string $vista, string $query = null)
    {
        Error::captureError();
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
