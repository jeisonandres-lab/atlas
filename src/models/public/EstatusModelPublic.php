<?php

namespace App\Atlas\models\public;

use App\Atlas\models\private\EstatusModel;

class EstatusModelPublic extends EstatusModel
{
    public function __construct()
    {
        parent::__construct();
    }

    // Getter para obtener los estatus
    public function getDatosEstatus($parametro)
    {
        return $this->datosEstatus($parametro);
    }

    // Getter para actualizar los estatus
    public function getActulizarEstatus($tabla, $datos, $condicion)
    {
        return $this->actulizarEstatus($tabla, $datos, $condicion);
    }

    // Getter para registrar estatus
    public function getRegistrarEstatus($tabla, $datos)
    {
        return $this->registrarEstatus($tabla, $datos);
    }

    // Getter para valdiar el estatus del estatus
    public function getValidarEstatus($tabla, $estatus)
    {
        return $this->verificarEstatus($tabla, $estatus);
    }

    // Getter para obtener dato por medio del ID
    public function getDatosEstatusID($parametro)
    {
        return $this->datosEstatusID($parametro);
    }
}