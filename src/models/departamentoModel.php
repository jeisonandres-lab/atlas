<?php

namespace App\Atlas\models;

use App\Atlas\config\Conexion;

class departamentoModel extends Conexion
{
    // Metodos de la Clase Privada
    private function datosDepartamento()
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM departamento");
        return $sql;
    }

    private function actulizarDepartamento($tabla, $datos, $condicion)
    {
        $sql = $this->actualizarDatos($tabla, $datos, $condicion);
        return $sql;
    }

    private function registrarDepartamento($tabla, $datos)
    {
        $sql = $this->guardarDatos($tabla, $datos);
        return $sql;
    }

    // Getters Para Accder a los Metodos de la Clase
    public function getDatosDepartamento()
    {
        return $this->datosDepartamento();
    }

    public function getActulizarDepartamento($tabla, $datos, $condicion)
    {
        return $this->actulizarDepartamento($tabla, $datos, $condicion);
    }

    public function getRegistrarDepartamento($tabla, $datos)
    {
        return $this->registrarDepartamento($tabla, $datos);
    }
}
