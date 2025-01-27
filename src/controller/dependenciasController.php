<?php

namespace App\Atlas\controller;

use App\Atlas\models\dependenciasModel;

class dependenciasController
{

    private $dependencia;

    public function __construct()
    {
        $this->dependencia = new dependenciasModel();
    }

    public function datosDependencia($tabla)
    {
        return $this->dependencia->getDatosDependencia($tabla);
    }
}
