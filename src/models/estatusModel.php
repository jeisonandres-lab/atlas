<?php
namespace App\Atlas\models;
use App\Atlas\config\Conexion;

class estatusModel extends Conexion{

    // Metodos de la Clase Privada
    private function datosEstatus()
    {
        $parametro = ['1'];
        $sql = $this->ejecutarConsulta("SELECT * FROM estatus WHERE activo = ? ", $parametro);
        return $sql;
    }

    private function actulizarEstatus($tabla, $datos, $condicion)
    {
        $sql = $this->actualizarDatos($tabla, $datos, $condicion);
        return $sql;
    }

    private function registrarEstatus($tabla, $datos)
    {
        $sql = $this->guardarDatos($tabla, $datos);
        return $sql;
    }

    private function verificarEstatus($tabla, $estatus)
    {
        $parametro = [$estatus];
        $sql = $this->ejecutarConsulta("SELECT * FROM $tabla WHERE estatus = ?", $parametro);

        return $sql;
    }

    private function datosEstatusID($parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM estatus WHERE id_estatus = ?", $parametro);

        return $sql;
    }
    // Getters Para Accder a los Metodos de la Clase
    public function getDatosEstatus()
    {
        return $this->datosEstatus();
    }

    public function getActulizarEstatus($tabla, $datos, $condicion)
    {
        return $this->actulizarEstatus($tabla, $datos, $condicion);
    }

    public function getRegistrarEstatus($tabla, $datos)
    {
        return $this->registrarEstatus($tabla, $datos);
    }

    public function getValidarEstatus($tabla, $estatus)
    {
        return $this->verificarEstatus($tabla, $estatus);
    }

    public function getDatosEstatusID($parametro)
    {
        return $this->datosEstatusID($parametro);
    }

}