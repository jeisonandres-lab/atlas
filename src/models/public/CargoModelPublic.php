<?php

namespace App\Atlas\models\public;

use App\Atlas\models\private\CargoModel;
class CargoModelPublic extends CargoModel
{
    public function __construct(){
        parent::__construct();
    }

    public function getDatosCargo()
    {
        return $this->datosCargo();
    }

    public function getVerificarCargo($tabla, $cargo)
    {
        return $this->verificarCargo($tabla, $cargo);
    }

    public function getObtenerDatosCargo($parametros)
    {
        return $this->obtenerDatosCargo($parametros);
    }

    public function getObtenerCargoGeneral(){
        return $this->obtenerCargoGeneral();
    }
}