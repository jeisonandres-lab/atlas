<?php

namespace App\Atlas\models;

use App\Atlas\config\Conexion;

class familiarModel extends Conexion
{

    // existe familiar inces por cedula
    private function existeFamiliarIncesPorCedula( array $cedula): bool
    {
        $sqlID = $this->ejecutarConsulta(
            "SELECT dfi.idPersonal
        FROM datosfamiliarinces dfi
        INNER JOIN datospersonales dp ON dfi.idPersonal = dp.id_personal
        WHERE dp.cedula = ?",
            $cedula
        );

        return !empty($sqlID);
    }

    // existe familiar inces por idpersonal la persona afiliar
    private function existeFamiliarIncesPorIDPersonal(array $idPersonal): bool
    {
        $sqlID = $this->ejecutarConsulta(
            "SELECT dfi.idPersonal
        FROM datosfamiliarinces dfi
        WHERE dfi.idPersonal = ?",
            $idPersonal
        );

        return !empty($sqlID);
    }

    // exisste familiar inces empleado por id
    private function existeFamiliarIncesPorIDEmpleado(array $idEmpleado): bool
    {
        $sqlID = $this->ejecutarConsulta(
            "SELECT dfi.idEmpleado
        FROM datosfamiliarinces dfi
        WHERE dfi.idEmpleado = ?",
            $idEmpleado
        );

        return !empty($sqlID);
    }




    /// GETTER DE EXISTENCIA DEL FAMILIAR INCES por cedula
    public function getExisteFamiliarIncesPorCedula($cedula)
    {
        return $this->existeFamiliarIncesPorCedula($cedula);
    }


    /// GETTER DE EXISTENCIA DEL FAMILIAR INCES por id personal
    public function getexisteFamiliarIncesPorIDPersonal($idPersonal)
    {
        return $this->existeFamiliarIncesPorIDPersonal($idPersonal);
    }


    /// GETTER DE EXISTENCIA DEL FAMILIAR INCES por id empleado
    public function getExisteFamiliarIncesPorIDEmpleado($idEmpleado)
    {
        return $this->existeFamiliarIncesPorIDEmpleado($idEmpleado);
    }
}
