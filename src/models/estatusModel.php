<?php
namespace App\Atlas\models;
use App\Atlas\config\Conexion;

class estatusModel extends Conexion{

    private function datosEstatus(){
        $sql = $this->ejecutarConsulta("SELECT * FROM estatus");
        return $sql;
    }

    private function datosCargo(){
        $sql = $this->ejecutarConsulta("SELECT * FROM cargo");
        return $sql;
    }

    public function getDatosEstatus(){
        return $this->datosEstatus();
    }
    
    public function getDatosCargo(){
        return $this->datosCargo();
    }

}