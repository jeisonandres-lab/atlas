<?php
namespace App\Atlas\models;
use App\Atlas\config\Conexion;

class AuditoriaModel extends Conexion {

    private function registrarAuditoria($tabla, $parametros) {
        $sql = $this->guardarDatos($tabla, $parametros);
        return $sql;
    }

    public function getRegistrarAuditoria($tabla, $parametros) {
        return  $this->registrarAuditoria($tabla, $parametros);
    }
}