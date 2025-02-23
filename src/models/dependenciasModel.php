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

    private function obtenerdependencia(array $parametro){
       return $sql = $this->ejecutarConsulta("SELECT * FROM dependencia depe INNER JOIN estados es ON depe.idEstado = es.id_estado WHERE depe.id_dependencia = ? ", $parametro);
    }

    private function actulizarDependencia($tabla, $datos, $condicion)
    {
        $sql = $this->actualizarDatos($tabla, $datos, $condicion);
        return $sql;
    }

    private function obtenerEstados()
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM estados");
        return $sql;
    }

    private function verificarDependencia($parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM dependencia WHERE dependencia = ?", $parametro);
        return $sql;
    }
    private function registrarPersonal2($tabla, $datos)
    {
        $sql = $this->guardarDatos($tabla, $datos);
        return $sql;
    }

    private function verificarCodigo($tabla, $codigo)
    {
        if ($codigo == "SIN-CDG") {
            $parametro = [''];
        } else {
            $parametro = [$codigo];
        }
        $sql = $this->ejecutarConsulta("SELECT * FROM $tabla WHERE codigo = ?", $parametro);
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

    public function getObtenerEstados()
    {
        return $this->obtenerEstados();
    }

    public function getRegistrar2($tabla, $datos)
    {
        return $this->registrarPersonal2($tabla, $datos);
    }

    public function getobtenerDependencia(array $parametro)
    {
        return $this->obtenerdependencia($parametro);
    }

    public function getVerificarCodigo($tabla, $codigo)
    {
        return $this->verificarCodigo($tabla, $codigo);
    }

    public function getVerificarDependencia($parametro)
    {
        return $this->verificarDependencia($parametro);
    }
}