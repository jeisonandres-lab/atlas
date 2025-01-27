<?php
namespace App\Atlas\models;
use App\Atlas\config\Conexion;

class estatusModel extends Conexion{

    // Metodos de la Clase Privada
    private function datosEstatus($tabla)
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM $tabla");
        return $sql;
    }

    private function actulizarEstatus($tabla, $datos, $condicion)
    {
        $sql = $this->actualizarDatos($tabla, $datos, $condicion);
        return $sql;
    }

    // Getters Para Accder a los Metodos de la Clase
    public function getDatosEstatus($tabla)
    {
        return $this->datosEstatus($tabla);
    }

    public function getActulizarEstatus($tabla, $datos, $condicion)
    {
        return $this->actulizarEstatus($tabla, $datos, $condicion);
    }

}