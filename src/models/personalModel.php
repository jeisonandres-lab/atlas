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
        $sql_personal = $this->ejecutarConsulta("SELECT * FROM datosPersonales WHERE cedula = ?", $parametro);
        foreach ($sql_personal as $row) {
            $idpersonal = $row['id_personal'];
            $prametro2 = [$idpersonal];
            $sql = $this->ejecutarConsulta("SELECT idPersonal, id_empleados FROM datosempleados WHERE idPersonal = ? ", $prametro2);
        }
        return $sql;
    }

    private function existeFamilar($parametro)
    {
        $cedula = $parametro[0];
        $carnet = $parametro[1];
        $sql = $this->ejecutarConsulta("SELECT * FROM datosfamilia WHERE cedula = ? ",  [$cedula]);
        if ($sql == "") {
            $sql = $this->ejecutarConsulta("SELECT * FROM datosfamilia WHERE codigoCarnet = ? ",  [$carnet]);
            return $sql;
        } else {
            return $sql;
        }
        return 'no se logro realizar ninguna de las consultas';
    }
    private function existeEmpleadofamiliar($parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM datosfamilia WHERE idEmpleado = ? ",  $parametro);
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
}
