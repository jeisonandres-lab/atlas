<?php

namespace App\Atlas\models\private;

use App\Atlas\config\EjecutarSQL;

class CargoModel extends EjecutarSQL
{
    // Metodos de la Clase Privada
    protected function datosCargo()
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM cargo");
        return $sql;
    }

    protected function obtenerCargoGeneral(){
        $sql = $this->ejecutarConsulta("SELECT * FROM cargo c WHERE c.activo = 1");
        return $sql;
    }

    protected function actulizarCargo($tabla, $datos, $condicion)
    {
        $sql = $this->actualizarDatos($tabla, $datos, $condicion);
        return $sql;
    }

    protected function obtenerDatosCargo($parametros)
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM cargo WHERE id_cargo = ?", $parametros);
        return $sql;
    }

    protected function registrarCargo($tabla, $datos)
    {
        $sql = $this->guardarDatos($tabla, $datos);
        return $sql;
    }

    protected function verificarCargo($tabla, $cargo)
    {
        $parametro = [$cargo];
        $sql = $this->ejecutarConsulta("SELECT * FROM $tabla WHERE cargo = ?", $parametro);

        return $sql;
    }

}
