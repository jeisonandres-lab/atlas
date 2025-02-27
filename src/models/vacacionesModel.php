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

    private function datosAusenciaID(array $parametros){
        $sql = $this->ejecutarConsulta("SELECT *
        FROM ausenciajustificada au
        INNER JOIN datosempleados dp ON au.idEmpleado = dp.id_empleados
        INNER JOIN datospersonales dpe ON dp.idPersonal = dpe.id_personal
        INNER JOIN cargo ca ON dp.idCargo = ca.id_cargo
        WHERE au.id_ausencia = ?", $parametros);
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

    private function datosAusencia(array $parametros){
        $sql = $this->ejecutarConsulta("SELECT *
        FROM ausenciajustificada au
        INNER JOIN datosempleados dp ON au.idEmpleado = dp.id_empleados
        INNER JOIN datospersonales dpe ON dp.idPersonal = dpe.id_personal
        WHERE au.activo = ?", $parametros);
        return $sql;
    }

    private function totaldatosAusencia(){
        $sql = $this->ejecutarConsulta("SELECT au.*, dp.*, dpe.*, au.activo AS estado
        FROM ausenciajustificada au
        INNER JOIN datosempleados dp ON au.idEmpleado = dp.id_empleados
        INNER JOIN datospersonales dpe ON dp.idPersonal = dpe.id_personal");
        return $sql;
    }

    private function actualizarAusencia($tabla, $datos, $condicion){
        $sql = $this->actualizarDatos($tabla, $datos, $condicion);
        return $sql;
    }

    private function registrarVacaciones($tabla, $datos){
        $sql = $this->guardarDatos($tabla, $datos);
        if ($sql) { // Éxito
            return true;
        } else { // Fallo
            return false;
        }
    }

    private function validarVacionesAno(array $parametros){
        $sql = $this->ejecutarConsulta("SELECT * FROM asignarvacaciones WHERE idEmpleado = ? AND ano = ?", $parametros);
        if (empty($sql)) {
            return true;
        }else{
            return false;
        }
    }

    private function datosVacaciones(){
        $sql = $this->ejecutarConsulta("SELECT *, DATE_FORMAT(av.fecha, '%Y-%m-%d') AS fechaFormat FROM asignarvacaciones av
        INNER JOIN datosempleados dp ON av.idEmpleado = dp.id_empleados
        INNER JOIN datospersonales dpe ON dp.idPersonal = dpe.id_personal INNER JOIN cargo ca ON dp.idCargo = ca.id_cargo");
        return $sql;
    }

    private function exisVacaciones(array $parametros){
        $sql = $this->ejecutarConsulta("SELECT * FROM asignarvacaciones av INNER JOIN datosempleados dp ON av.idEmpleado = dp.id_empleados
        INNER JOIN datospersonales dpe ON dp.idPersonal = dpe.id_personal WHERE dpe.cedula = ? AND av.ano = ?", $parametros);

        if (empty($sql)) {
            return false;
        }else{
            return $sql;
        }

    }

    private function datosCedulaVacaciones(array $parametros){
        $sql = $this->ejecutarConsulta("SELECT * FROM asignarvacaciones av INNER JOIN datosempleados dp ON av.idEmpleado = dp.id_empleados
        INNER JOIN datospersonales dpe ON dp.idPersonal = dpe.id_personal WHERE dpe.cedula = ?", $parametros);
        return $sql;
    }

    private function totalDatosEmpeladosID(array $parametros){
        $sql = $this->ejecutarConsulta(
            "SELECT * FROM datosEmpleados de INNER JOIN datosPersonales dp ON de.idPersonal = dp.id_personal INNER JOIN estatus e ON de.idEstatus = e.id_estatus
            INNER JOIN cargo c ON de.idCargo = c.id_cargo
            INNER JOIN dependencia depe ON de.idDependencia = depe.id_dependencia
            INNER JOIN departamento d ON de.idDepartamento = d.id_departamento WHERE de.id_empleados = ?",
            $parametros
        );
        return $sql;
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

    public function getDatosAusencia(array $parametros){
        return $this->datosAusencia($parametros);
    }

    public function getDatosAusenciaID(array $parametros){
        return $this->datosAusenciaID($parametros);
    }

    public function getActualizarAusencia(string $tabla, array $datos,  $condicion){
        $result = $this->actualizarAusencia($tabla, $datos, $condicion);
        return $result; // Retorna true o false según el resultado de actualizarAusencia
    }

    public function getTotalDatosAusencia(){
        return $this->totaldatosAusencia();
    }

    public function getRegistrarVacaciones(string $tabla, array $datos){
        $result = $this->registrarVacaciones( $tabla,  $datos);
        return $result; // Retorna true o false según el resultado de registrarVacaciones
    }

    public function getValidarVacionesAno(array $parametros){
        $result = $this->validarVacionesAno($parametros);
        return $result;
    }

    public function getDatosVacaciones(){
        return $this->datosVacaciones();
    }

    public function getExisVacaciones(array $parametros){
        return $this->exisVacaciones($parametros);
    }

    public function getDatosCedulaVacaciones(array $parametros){
        return $this->datosCedulaVacaciones($parametros);
    }

    public function getTotalDatosEmpeladosID(array $parametros){
        return $this->totalDatosEmpeladosID($parametros);
    }


}