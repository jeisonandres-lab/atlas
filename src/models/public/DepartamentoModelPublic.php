<?php

namespace App\Atlas\models\public;

use App\Atlas\models\private\DepartamentoModel;

class DepartamentoModelPublic extends DepartamentoModel
{
    public function __construct(){
        parent::__construct();
    }

    public function getDatosDepartamento()
    {
        return $this->datosDepartamento();
    }

    public function getValidarDepartamento($tabla, $departamento)
    {
        return $this->verificarDepartamento($tabla, $departamento);
    }

    public function getObtenerDatosDepartamento($parametro)
    {
        return $this->obtenerDatosDepartamento($parametro);
    }

    public function getObtenerDepartamentoGeneral(){
        return $this->obtenerDepartamentoGeneral();
    }
}