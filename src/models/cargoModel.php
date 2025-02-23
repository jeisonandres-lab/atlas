<?php

namespace App\Atlas\models;

use App\Atlas\config\Conexion;

class cargoModel extends Conexion
{
    // Metodos de la Clase Privada
    private function datosCargo()
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM cargo");
        return $sql;
    }

    private function actulizarCargo($tabla, $datos, $condicion)
    {
        $sql = $this->actualizarDatos($tabla, $datos, $condicion);
        return $sql;
    }

    private function obtenerDatosCargo($parametros)
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM cargo WHERE id_cargo = ?", $parametros);
        return $sql;
    }

    private function registrarCargo($tabla, $datos)
    {
        $sql = $this->guardarDatos($tabla, $datos);
        return $sql;
    }

    private function verificarCargo($tabla, $cargo)
    {
        $parametro = [$cargo];
        $sql = $this->ejecutarConsulta("SELECT * FROM $tabla WHERE cargo = ?", $parametro);

        return $sql;
    }

    // Getters Para Accder a los Metodos de la Clase
    public function getDatosCargo()
    {
        return $this->datosCargo();
    }

    public function getActulizarCargo($tabla, $datos, $condicion)
    {
        return $this->actulizarCargo($tabla, $datos, $condicion);
    }

    public function getRegistrarCargo($tabla, $datos)
    {
        return $this->registrarCargo($tabla, $datos);
    }

    public function getVerificarCargo($tabla, $cargo)
    {
        return $this->verificarCargo($tabla, $cargo);
    }

    public function getObtenerDatosCargo($parametros)
    {
        return $this->obtenerDatosCargo($parametros);
    }
}
