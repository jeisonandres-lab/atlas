<?php

namespace App\Atlas\models\private;

use App\Atlas\config\EjecutarSQL;

class DependenciasModel extends EjecutarSQL
{
    // Obtener dependencias
    protected function datosDependencia(array $parametro = ['1'])
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM dependencia depe
        INNER JOIN estados es ON depe.idEstado = es.id_estado
        WHERE depe.activo = ? ", $parametro);
        return $sql;
    }

    // Obtener dependencia por medio de su ID
    protected function obtenerdependencia(array $parametro){
       return $sql = $this->ejecutarConsulta("SELECT * FROM dependencia depe INNER JOIN estados es ON depe.idEstado = es.id_estado WHERE depe.id_dependencia = ? ", $parametro);
    }

    // Verificar dependencia por nombre
    protected function verificarDependencia(array $parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM dependencia WHERE dependencia = ?", $parametro);
        return $sql;
    }

    // Verificar codigo de dependencia
    protected function verificarCodigo(string $tabla, array $parametro)
    {
        if ($parametro == "SIN-CDG") {
            $parametroFinal = [''];
        } else {
            $parametroFinal = [$parametro];
        }
        $sql = $this->ejecutarConsulta("SELECT * FROM $tabla WHERE codigo = ?", $parametroFinal);
        return $sql;
    }

    // protected function obtenerEstados()
    // {
    //     $sql = $this->ejecutarConsulta("SELECT * FROM estados");
    //     return $sql;
    // }
}