<?php

namespace App\Atlas\controller;

use App\Atlas\models\estatusModel;

class estatusController
{
    private $estatus;

    public function __construct()
    {
        $this->estatus = new estatusModel();
    }

    public function datosEstatus($tabla)
    {
        return $this->estatus->getDatosEstatus($tabla);
    }
}
