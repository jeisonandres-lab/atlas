<?php

namespace App\Atlas\controller;

use App\Atlas\models\departamentoModel;

class departamentoController
{
    private $departamento;

    public function __construct()
    {
        $this->departamento = new departamentoModel();
    }

    public function DatosDepartamento($tabla)
    {
        return $this->departamento->getDatosDepartamento($tabla);
    }
}