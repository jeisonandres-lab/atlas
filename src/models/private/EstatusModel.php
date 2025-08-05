<?php
namespace App\Atlas\models\private;

use App\Atlas\config\EjecutarSQL;

class EstatusModel extends EjecutarSQL{

    // Metodos de la Clase Privada
    protected function datosEstatus($parametro = ['1'])
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM estatus WHERE activo = ? ", $parametro);
        return $sql;
    }

    public function obtenerEstatusGeneral(){
        $sql = $this->ejecutarConsulta("SELECT id_estatus, estatus FROM estatus WHERE activo = 1 ");
        return $sql;
    }

    protected function actulizarEstatus($tabla, $datos, $condicion)
    {
        $sql = $this->actualizarDatos($tabla, $datos, $condicion);
        return $sql;
    }

    protected function registrarEstatus($tabla, $datos)
    {
        $sql = $this->guardarDatos($tabla, $datos);
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