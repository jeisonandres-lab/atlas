<?php

namespace App\Atlas\models;

use App\Atlas\config\Conexion;

class departamentoModel extends Conexion
{
    // Metodos de la Clase Privada
    private function datosDepartamento($tabla)
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM $tabla");
        return $sql;
    }

    private function actulizarDepartamento($tabla, $datos, $condicion)
    {
        $sql = $this->actualizarDatos($tabla, $datos, $condicion);
        return $sql;
    }

    // Getters Para Accder a los Metodos de la Clase
    public function getDatosDepartamento($tabla)
    {
        return $this->datosDepartamento($tabla);
    }

    public function getActulizarDepartamento($tabla, $datos, $condicion)
    {
        return $this->actulizarDepartamento($tabla, $datos, $condicion);
    }
}
