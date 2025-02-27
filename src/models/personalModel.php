<?php

namespace App\Atlas\models;

use App\Atlas\config\Conexion;

class personalModel extends Conexion
{

    private function registrarPersonal($tabla, $datos)
    {
        $sql = $this->guardarDatos($tabla, $datos);
        return $sql;
    }

    private function registrarEmpleado($tabla, $datos)
    {
        $sql = $this->guardarDatos($tabla, $datos);
        return $sql;
    }

    private function registraDOCS($tabla, $datos)
    {
        $sql = $this->guardarDatos($tabla, $datos);
        return $sql;
    }

    private function validarPersonal($parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT cedula FROM datosPersonales WHERE cedula = ?", $parametro);
        if ($sql) {
            $sql = false;
        } else {
            $sql = true;
        }
        return $sql;
    }

    private function DatosPerosnal($parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT id_personal, cedula FROM datospersonales WHERE cedula = ?", $parametro);
        return $sql;
    }

    private function totalDatospersonal($parametro)
    {
        $sql = $this->ejecutarConsulta(
            "SELECT * FROM datosEmpleados de INNER JOIN datosPersonales dp ON de.idPersonal = dp.id_personal INNER JOIN estatus e ON de.idEstatus = e.id_estatus
            INNER JOIN cargo c ON de.idCargo = c.id_cargo
            INNER JOIN dependencia depe ON de.idDependencia = depe.id_dependencia
            INNER JOIN departamento d ON de.idDepartamento = d.id_departamento WHERE dp.cedula = ?",
            $parametro
        );
        return $sql;
    }

    private function totalDatosID($parametro)
    {
        $sql = $this->ejecutarConsulta(
            "SELECT * FROM datosEmpleados de INNER JOIN datosPersonales dp ON de.idPersonal = dp.id_personal INNER JOIN estatus e ON de.idEstatus = e.id_estatus
            INNER JOIN cargo c ON de.idCargo = c.id_cargo
            INNER JOIN dependencia depe ON de.idDependencia = depe.id_dependencia
            INNER JOIN departamento d ON de.idDepartamento = d.id_departamento WHERE dp.id_personal = ?",
            $parametro
        );
        return $sql;
    }

    private function validarEmpleado($parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM datosempleados WHERE idpersonal = ? ", $parametro);
        return $sql;
    }

    private function validarEmpleado_datos($parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT *  FROM datosempleados de INNER JOIN datospersonales dp ON de.idPersonal =  dp.id_personal WHERE dp.cedula  = ?", $parametro);
        return $sql;
    }

    private function existeFamilar($parametro)
    {
        $cedula = $parametro[0];
        $carnet = $parametro[1];
        $tomo = $parametro[2];
        $folio = $parametro[3];
        $sql = $this->ejecutarConsulta("SELECT * FROM datosfamilia WHERE tomo = ? AND folio = ?", [$tomo, $folio]);
        if (empty($sql)) {
            $sql = $this->ejecutarConsulta("SELECT * FROM datosfamilia WHERE cedula = ? ",  [$cedula]);
            if (empty($sql)) {
                $sql = $this->ejecutarConsulta("SELECT * FROM datosfamilia WHERE codigoCarnet = ? ",  [$carnet]);
            }
        }
        return $sql;
    }

    private function existeFamiliarID($parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM datosfamilia WHERE id_ninos = ? ",  $parametro);
        return $sql;
    }

    private function existeEmpleadofamiliar($parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM datosfamilia WHERE idEmpleado = ? ",  $parametro);
        return $sql;
    }

    private function datosFamiliar($parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT df . *, dp . cedula AS cedulaEmpleado,
        dp.primerNombre AS primerNombreEmpleado,
        dp.primerApellido AS primerApellidoEmpleado
        FROM datosfamilia df
        INNER JOIN datosempleados de
        ON de.id_empleados = df.idEmpleado
        INNER JOIN datospersonales dp ON dp.id_personal = de.idPersonal
        WHERE df.id_ninos = ? ",  $parametro);
        return $sql;
    }

    private function datosFamiliarEmpleado($parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT df . *, dp . cedula AS cedulaEmpleado,
        df . primerNombre AS primerNombreFamiliar, df . primerApellido AS primerApellidoFamiliar,
        df . segundoNombre AS segundoNombreFamiliar, df . segundoApellido AS segundoApellidoFamiliar,
        df . cedula AS cedulaFamiliar, df . diaNacimiento AS diaNacimientoFamiliar, df . mesNacimiento AS mesNacimientoFamiliar,
        df . anoNacimiento AS anoNacimientoFamiliar,
        dp.primerNombre AS primerNombreEmpleado,
        dp.primerApellido AS primerApellidoEmpleado
        FROM datosfamilia df
        INNER JOIN datosempleados de
        ON de.id_empleados = df.idEmpleado
        INNER JOIN datospersonales dp ON dp.id_personal = de.idPersonal
        WHERE df.idEmpleado = ? ",  $parametro);

        return $sql;
    }

    private function actualuzarDatos($tabla, $datos, $condicion)
    {
        $sql = $this->actualizarDatos($tabla, $datos, $condicion);
        return $sql;
    }

    public function actualizarDatosFamiliar()
    {
        $sql = $this->ejecutarConsulta("");
        return $sql;
    }

    public function actualizarPersonalMode(
        $primerNombre,
        $segundoNombre,
        $primerApellido,
        $segundoApellido,
        $cedula,
        $civil,
        $ano,
        $mes,
        $dia,
        $fecha,
        $hora
    ) {
        $sql = $this->ejecutarConsulta("UPDATE
        datospersonales SET primerNombre='$primerNombre',
        segundoNombre='$segundoNombre',primerApellido='$primerApellido',
        segundoApellido='$segundoApellido',cedula='$cedula',
        estadoCivil='$civil',diaNacimiento='$dia',mesNacimiento='$mes',
        anoNacimiento='$ano',fecha='$fecha',
        hora=' $hora' WHERE cedula = '$cedula' ");

        if (!empty($sql)) {
            $sql = false;
        } else {
            $sql = true;
        }
        return $sql;
    }

    public function actualizarEmpleadoMode(
        $idEstatus,
        $idCargo,
        $idDependencia,
        $telefono,
        $idDepartamento,
        $fecha,
        $hora,
        $idPersonal,
        $nivelAcademico
    ) {
        $sql = $this->ejecutarConsulta("UPDATE
        datosempleados
        SET
        idEstatus='$idEstatus',
        idCargo='$idCargo',
        idDependencia='$idDependencia',
        idDepartamento=' $idDepartamento',
        nivelAcademico='$nivelAcademico',
        telefono=' $telefono',activo='1',fecha='$fecha',hora='$hora' WHERE idPersonal = '$idPersonal'");

        if (!empty($sql)) {
            $sql = false;
        } else {
            $sql = true;
        }
        return $sql;
    }

    // Total de datos de empleado
    public function totalDatosEmpleado(){
        $sql = $this->ejecutarConsulta("SELECT *
        FROM datosempleados de
        INNER JOIN estatus e ON de.idEstatus = e.id_estatus
        INNER JOIN cargo c ON de.idCargo = c.id_cargo
        INNER JOIN dependencia depe ON de.idDependencia = depe.id_dependencia
        INNER JOIN departamento d ON de.idDepartamento = d.id_departamento
        INNER JOIN datospersonales dp ON dp.id_personal = de.idPersonal");

        return $sql;
    }

    public function getRegistrar($tabla, $datos)
    {
        return $this->registrarPersonal($tabla, $datos);
    }

    public function getRegistrarEmpleado($tabla, $datos)
    {
        return $this->registrarEmpleado($tabla, $datos);
    }

    public function getRegistrarDOCS($tabla, $datos)
    {
        return $this->registraDOCS($tabla, $datos);
    }

    public function getExistePersonal($parametro)
    {
        return $this->validarPersonal($parametro);
    }

    public function getExisteEmpleado($parametro)
    {
        return $this->validarEmpleado($parametro);
    }

    public function getDatosPersonal($parametro)
    {
        return $this->DatosPerosnal($parametro);
    }

    public function getTotalDatosPersonal($parametro)
    {
        return $this->totalDatospersonal($parametro);
    }

    public function getExisteEmpleado_datos($parametro)
    {
        return $this->validarEmpleado_datos($parametro);
    }

    public function getExisteFamiliar($parametro)
    {
        return $this->existeFamilar($parametro);
    }

    public function getDatosFamiliar($parametro)
    {
        return $this->datosFamiliar($parametro);
    }

    public function getExisteEmpleadoFamiliar($parametro)
    {
        return $this->existeEmpleadofamiliar($parametro);
    }

    public function getExisteFamiliarID($parametro)
    {
        return $this->existeFamiliarID($parametro);
    }

    public function getActualizar($tabla, $datos, $condicion)
    {
        return $this->actualuzarDatos($tabla, $datos, $condicion);
    }

    public function getDatosFamiliarEmpleado($parametro)
    {
        return $this->datosFamiliarEmpleado($parametro);
    }

    public function getTotalDatosEmpleado(){
        return $this->totalDatosEmpleado();
    }

    public function getTotalDatosID($parametro){
        return $this->totalDatosID($parametro);
    }
}
