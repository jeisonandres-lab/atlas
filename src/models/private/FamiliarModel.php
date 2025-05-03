<?php

namespace App\Atlas\models;

use App\Atlas\config\EjecutarSQL;

class FamiliarModel extends EjecutarSQL
{

    // REGISTRAR DATOS
    protected function registrarDatos(string $tabla, array $datos)
    {
        $sql = $this->guardarDatos($tabla, $datos);
        return $sql;
    }

    // EXISTE FAMILIAR POR TOMO, FOLIO Y CÉDULA
    protected function existeFamilar(array $parametro)
    {
        $cedula = $parametro[0];
        $tomo = $parametro[1];
        $folio = $parametro[2];

        // Primero, consulta por cédula
        $sqlCedula = $this->ejecutarConsulta("SELECT df.id_ninos, df.cedula FROM datosfamilia df WHERE df.cedula = ? AND df.activo = 1", [$cedula]);

        if (!empty($sqlCedula)) {
            return [
                'mensaje' => "La cédula del familiar ya existe.",
                'datos' => $sqlCedula,
                'exito' => true
            ];
        } else {
            // // Si la cédula no fue encontrada, consulta por tomo
            // $sqlTomo = $this->ejecutarConsulta("SELECT df.id_ninos, df.tomo FROM datosfamilia df WHERE df.tomo = ?", [$tomo]);

            // if (!empty($sqlTomo)) {
            //     return [
            //         'mensaje' => "El tomo ya existe.",
            //         'datos' => $sqlTomo
            //     ];
            // } else {

            // }
            // Si el tomo no fue encontrado, consulta por folio
            $sqlFolio = $this->ejecutarConsulta("SELECT df.id_ninos, df.folio FROM datosfamilia df WHERE df.folio = ?", [$folio]);

            if (!empty($sqlFolio)) {
                return [
                    'mensaje' => "El folio ya existe.",
                    'datos' => $sqlFolio
                ];
            } else {
                return false;
            }
        }
    }

    // existe familiar inces por cedula
    private function existeFamiliarIncesPorCedula(array $cedula): bool
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

    //DATOS DE UN FAMILIAR INCES
    private function datosFamiliarIncesFiltrado(array $parametro = [], $clausula = "")
    {
        $sql = $this->ejecutarConsulta("SELECT
            de.id_empleados,
            dpf.id_personal AS idEmpleadoAsignado,
            dp.primerNombre AS nombreEmpleado,
            dp.primerApellido AS apellidoEmpleado,
            dpf.primerNombre AS nombreEmpleadoAsignado,
            dpf.primerApellido AS apellidoEmpledoAsignado,
            dpf.cedula AS cedulaEmpleadoAsignado,
            dpf.edadPersonal AS edadEmpleadoAsignado
            FROM datosfamiliarinces dfi
            LEFT JOIN datosempleados de ON dfi.idEmpleado = de.id_empleados
            LEFT JOIN datospersonales dp ON de.idPersonal = dp.id_personal
            LEFT JOIN datospersonales dpf ON dfi.idPersonal = dpf.id_personal
            WHERE $clausula", $parametro);

        return $sql;
    }

    // DATOS DE FAMILIAR POR FILTRO
    private function datosFamiliarFiltro(string $clausula, array $parametro)
    {
        $sql = $this->ejecutarConsulta(
            "SELECT df . *,
            df.edad AS edadFamiliar,
            df.anoNacimiento AS anoFamiliar,
            df.diaNacimiento AS diaFamiliar,
            df.mesNacimiento AS mesFamiliar,
            df.primerNombre AS primerNombreFamiliar,
            df.segundoNombre AS segundoNombreFamiliar,
            df.primerApellido AS primerApellidoFamiliar,
            df.segundoApellido AS segundoApellidoFamiliar,
            df.cedula AS cedulaFamiliar,
            dp.cedula AS cedulaEmpleado,
            dp.primerNombre AS primerNombreEmpleado,
            dp.primerApellido AS primerApellidoEmpleado
            FROM datosfamilia df
            INNER JOIN datosempleados de
            ON de.id_empleados = df.idEmpleado
            INNER JOIN datospersonales dp ON dp.id_personal = de.idPersonal
        WHERE $clausula",
            $parametro
        );
        return $sql;
    }

    /*-------------------- EXISTE FAMILIAR INCES --------------------- */
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

    // GETTER DE EXISTENCIA DEL FAMILIAR INCES por id empleado
    public function getExisteFamiliarIncesPorIDEmpleado($idEmpleado)
    {
        return $this->existeFamiliarIncesPorIDEmpleado($idEmpleado);
    }

    /*-------------------- EXISTE FAMILIARES --------------------- */
    // GETTER DE VALIDAR EXISTENCIA DE FAMILIAR
    public function getExisteFamilar($parametro)
    {
        return $this->existeFamilar($parametro);
    }

    /*-------------------- FAMILIARES FILTRO--------------------- */
    // FILTAR DATOS DEL FAMILIAR
    public function getDatosFamiliarFiltro($clausula, $parametro)
    {
        return $this->datosFamiliarFiltro($clausula, $parametro);
    }

    public function getDatosFamiliarIncesFiltrado($parametro, $clausula){
        return $this->datosFamiliarIncesFiltrado($parametro, $clausula);
    }

    /*-------------------- REGISTROS Y ACTUALIZACION --------------------- */
    // GETTERS PARA REGISTRAR DATOS
    public function getRegistrar($tabla, $datos)
    {
        return $this->registrarDatos($tabla, $datos);
    }
}
