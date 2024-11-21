<?php
namespace App\Atlas\models;
use App\Atlas\config\Conexion;

class personalModel extends Conexion{

    private function registrarPersonal($tabla, $datos){
        $sql = $this->guardarDatos($tabla, $datos);
        return $sql;
    }

    private function registrarEmpleado($tabla, $datos){
        $sql = $this->guardarDatos($tabla, $datos);
        return $sql;
    }

    private function validarPersonal($parametro){
        $sql = $this->ejecutarConsulta("SELECT cedula FROM datosPersonales WHERE cedula = ?", $parametro);
        return $sql;
    }

    private function DatosPerosnal($parametro){
        $sql = $this->ejecutarConsulta("SELECT * FROM datosPersonales WHERE cedula = ?", $parametro);
        return $sql;
    }

    private function validarEmpleado($parametro){
        $sql = $this->ejecutarConsulta("SELECT idPersonal FROM datosempleados WHERE idpersonal = ? ", $parametro);
        return $sql;
    }

    public function getRegistrar($tabla, $datos){
       return $this->registrarPersonal($tabla, $datos);
    }

    public function getRegistrarEmpleado($tabla, $datos){
        return $this->registrarEmpleado($tabla, $datos);
    }

    public function getExistePersonal( $parametro){
        return $this->validarPersonal( $parametro);
    }

    public function getDatosPersonal($parametro){
        return $this->DatosPerosnal($parametro);
    }

    public function getExisteEmpleado($parametro){
        return $this->validarEmpleado($parametro);
    }


}