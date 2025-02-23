<?php
namespace App\Atlas\models;
use App\Atlas\config\Conexion;

class vacacionesModel extends Conexion {

    private function registrarAusencia($tabla, $datos){
        $sql = $this->guardarDatos($tabla, $datos);
        if ($sql) { // Éxito
            return true;
        } else { // Fallo
            return false;
        }
    }

    private function exisAusencia(array $parametros){
        $sql = $this->ejecutarConsulta("SELECT * FROM ausenciajustificada WHERE idEmpleado = ? AND (fechaInicio = ? OR fechaFinal = ?)", $parametros);
        return $sql;
    }

    private function estadoAusencia(array $parametros){
        $sql = $this->ejecutarConsulta("SELECT * FROM ausenciajustificada WHERE idEmpleado = ? AND activo = ?", $parametros);
        if (empty($sql)) {
            return false;
        }else{
            return true;
        }
    }

    public function getRegistrarAusencia(string $tabla, array $datos){
        $result = $this->registrarAusencia( $tabla,  $datos);
        return $result; // Retorna true o false según el resultado de registrarAusencia
    }

    public function getexisAusencia(array $parametros){
        $result = $this->exisAusencia($parametros);
        if (!empty($result)) {
            return ['existe' => true,  'datos' => $result];
        } else {
            return ['existe' => false, 'messenger' => 'No hay ausencias asignadas en las fechas proporcionadas.'];
        }
    }

    public function getEstadoAusencia(array $parametros){
        return $this->estadoAusencia($parametros);
    }


}