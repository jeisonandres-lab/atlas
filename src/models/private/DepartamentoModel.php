<?php

namespace App\Atlas\models\private;

use App\Atlas\config\EjecutarSQL;

class DepartamentoModel extends EjecutarSQL
{
    // Obtener departamentos esten o no esten activos
    protected function datosDepartamento()
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM departamento");
        return $sql;
    }

    // Obtener departamentos activos
    protected function obtenerDepartamentoGeneral()
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM departamento depa WHERE depa.activo = 1");
        return $sql;
    }


    protected function verificarDepartamento($tabla, $departamento)
    {
        $parametro = [$departamento];
        $sql = $this->ejecutarConsulta("SELECT * FROM $tabla WHERE departamento = ?", $parametro);

        return $sql;
    }

    protected function obtenerDatosDepartamento($parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM departamento WHERE id_departamento = ?", $parametro);

        return $sql;
    }
}
