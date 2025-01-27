<?php

namespace App\Atlas\models;

use App\Atlas\config\Conexion;

class cargoModel extends Conexion
{
    // Metodos de la Clase Privada
    private function datosCargo($tabla)
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM $tabla");
        return $sql;
    }

    private function actulizarCargo($tabla, $datos, $condicion)
    {
        $sql = $this->actualizarDatos($tabla, $datos, $condicion);
        return $sql;
    }

    // Getters Para Accder a los Metodos de la Clase
    public function getDatosCargo($tabla)
    {
        return $this->datosCargo($tabla);
    }

    public function getActulizarCargo($tabla, $datos, $condicion)
    {
        return $this->actulizarCargo($tabla, $datos, $condicion);
    }
}
