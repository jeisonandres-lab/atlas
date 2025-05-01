<?php

namespace App\Atlas\models\public;

use App\Atlas\models\private\AuditoriaModel;

class AuditoriaModelPublic extends AuditoriaModel
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getRegistrarAuditoria($tabla, $parametros) {
        return  $this->registrarAuditoria($tabla, $parametros);
    }
}