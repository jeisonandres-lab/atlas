<?php
namespace App\Atlas\models;
use App\Atlas\config\Conexion;

class dependenciasModel extends Conexion{

    private function datosDependencia(){
        $sql = $this->ejecutarConsulta("SELECT * FROM dependencia");
        return $sql;
    }

    private function datosDepartamentos(){
        $sql = $this->ejecutarConsulta("SELECT * FROM departamento");
        return $sql;
    }

    public function getDatosDependencia(){
        return $this->datosDependencia();
    }

    public function getDatosDepartamentos(){
        return $this->datosDepartamentos();
    }
}