<?php
namespace App\Atlas\models;

use App\Atlas\config\Conexion;

class UbicacionModel extends Conexion {

    public function estados(){
        return $this->ejecutarConsulta("SELECT * FROM estados");
    }

    public function municipio(array $parametro){
        $sql = $this->ejecutarConsulta("SELECT * FROM municipios WHERE  idEstados = ?", $parametro);
        if (empty($sql)) {
            $sql = false;
        }else{
            return $sql;
        }
    }

    public function parroquia(array $parametro){
        $sql = $this->ejecutarConsulta("SELECT * FROM parroquias WHERE  idMunicipio = ?", $parametro);
        if (empty($sql)) {
            $sql = false;
        }else{
            return $sql;
        }
    }


}