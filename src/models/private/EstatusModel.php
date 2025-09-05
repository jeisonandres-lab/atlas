<?php
namespace App\Atlas\models\private;

use App\Atlas\config\EjecutarSQL;

class EstatusModel extends EjecutarSQL{


    protected function datosEstatus($parametro = ['1'])
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM estatus WHERE activo = ? ", $parametro);
        return $sql;
    }

    protected function verificarEstatus($tabla, $estatus)
    {
        $parametro = [$estatus];
        $sql = $this->ejecutarConsulta("SELECT * FROM $tabla WHERE estatus = ?", $parametro);

        return $sql;
    }

    protected function datosEstatusID($parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM estatus WHERE id_estatus = ?", $parametro);

        return $sql;
    }

}