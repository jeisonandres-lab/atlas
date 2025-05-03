<?php

namespace App\Atlas\models;

use App\Atlas\config\EjecutarSQL;

class AuditoriaModelPublic extends EjecutarSQL
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getRegistrarAuditoria($tabla, $parametros) {
        return  $this->registrarAuditoria($tabla, $parametros);
    }
}