<?php
namespace App\Atlas\models;
use App\Atlas\config\Conexion;

class personalModel extends Conexion{

    private function registrarPersonal($tabla, $datos){
        $sql = $this->guardarDatos($tabla, $datos);
        return $sql;
    }


    public function getRegistrar($tabla, $datos){
       return $this->registrarPersonal($tabla, $datos);
    }
}