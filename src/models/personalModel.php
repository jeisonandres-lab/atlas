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
        return $sql;
    }

    private function DatosPerosnal($parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM datosPersonales WHERE cedula = ?", $parametro);
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
        if ($sql == "") {
            $sql = $this->ejecutarConsulta("SELECT * FROM datosfamilia WHERE cedula = ? ",  [$cedula]);
            if (empty($sql)) {
                $sql = $this->ejecutarConsulta("SELECT * FROM datosfamilia WHERE codigoCarnet = ? ",  [$carnet]);
            }
        }
        return $sql;
    }
    private function existeEmpleadofamiliar($parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM datosfamilia WHERE idEmpleado = ? ",  $parametro);
        return $sql;
    }

    private function actualuzarDatos($tabla, $datos, $condicion)
    {
        $sql = $this->actualizarDatos($tabla, $datos, $condicion);
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

    public function getExisteEmpleado_datos($parametro)
    {
        return $this->validarEmpleado_datos($parametro);
    }

    public function getExisteFamiliar($parametro)
    {
        return $this->existeFamilar($parametro);
    }

    public function getExisteEmpleadoFamiliar($parametro)
    {
        return $this->existeEmpleadofamiliar($parametro);
    }
    public function getActualizar($tabla, $datos, $condicion)
    {
        return $this->actualuzarDatos($tabla, $datos, $condicion);
    }
}
