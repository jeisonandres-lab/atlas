<?php
namespace App\Atlas\models\private;

use App\Atlas\config\EjecutarSQL;

class AuditoriaModel extends EjecutarSQL {

    protected function registrarAuditoria($tabla, $parametros) {
        $sql = $this->guardarDatos($tabla, $parametros);
        return $sql;
    }


}