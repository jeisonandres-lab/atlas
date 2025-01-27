<?php

namespace App\Atlas\controllers;
use App\Atlas\controller\dependenciasController;

class datosDecdController{
    private $dependencia;

    public function __construct()
    {
        $this->dependencia = new dependenciasController();
    }
}