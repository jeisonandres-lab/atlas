<?php

namespace App\Atlas\controller;

use App\Atlas\models\cargoModel;

class cargoController
{
    private $cargo;

    public function __construct()
    {
        $this->cargo = new cargoModel();
    }

    public function getDatosCargo($tabla)
    {
        return $this->cargo->getDatosCargo($tabla);
    }
}