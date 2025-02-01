<?php

namespace App\Atlas\models;

use App\Atlas\config\Conexion;

class dependenciasModel extends Conexion
{
    // Metodos de la Clase Privada
    private function datosDependencia()
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM dependencia");
        return $sql;
    }

    private function actulizarDependencia($tabla, $datos, $condicion)
    {
        $sql = $this->actualizarDatos($tabla, $datos, $condicion);
        return $sql;
    }

    // Getters Para Accder a los Metodos de la Clase
    public function getDatosDependencia()
    {
        return $this->datosDependencia();
    }

    public function getActulizarDependencia($tabla, $datos, $condicion)
    {
        return $this->actulizarDependencia($tabla, $datos, $condicion);
    }
}
