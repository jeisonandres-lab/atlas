<?php
namespace App\Atlas\models;
use App\Atlas\config\Conexion;

class personalModel extends Conexion{

    private function registrarPersonal($tabla, $datos){
        $sql = $this->guardarDatos($tabla, $datos);
        return $sql;
    }

    private function validarPersonal($cedula){
        $sql = $this->ejecutarConsulta("SELECT * FROM datosPersonales WHERE cedula = .$cedula");
        return $sql;
    }


    public function getRegistrar($tabla, $datos){
       return $this->registrarPersonal($tabla, $datos);
    }

    public function getPersonal($cedula): string{
        return $this->validarPersonal($cedula);
    }
}