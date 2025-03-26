<?php

namespace App\Atlas\models;

use App\Atlas\config\Conexion;

class personalModel extends Conexion
{

    // REGISTRAR DATOS
    private function registrarDatos(string $tabla, array $datos)
    {
        $sql = $this->guardarDatos($tabla, $datos);
        // Ejecutar las consultas adicionales
        // Reordenar IDs

        // Obtener el nombre de la primera columna
        $primeraColumna = $this->obtenerPrimeraColumna($tabla);

        if ($primeraColumna) {
            // Reordenar IDs
            $this->ejecutarConsulta("SET @row_number = 0;");
            $this->ejecutarConsulta("UPDATE " . $tabla . " SET " . $primeraColumna . " = (@row_number:=@row_number + 1) ORDER BY " . $primeraColumna . ";");
            $this->ejecutarConsulta("ALTER TABLE " . $tabla . " AUTO_INCREMENT = 1;");
        } else {
            // Manejar el caso en que no se pudo obtener el nombre de la primera columna
            error_log("No se pudo obtener el nombre de la primera columna de la tabla: " . $tabla);
        }
        return $sql;
    }

    //REGISTRAR DOCUMENTOS
    private function registraDOCS(string $tabla, array $datos)
    {
        $sql = $this->guardarDatos($tabla, $datos);
        return $sql;
    }

    // RETORNAR ID PERSONAL POR CÉDULA
    private function returnIDP(array $parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT id_personal
         FROM datospersonales dp
         WHERE dp.cedula = ?", $parametro);
        return $sql;
    }

    // RETORNAR ID EMPLEADO POR CÉDULA
    private function returnIDPE(array $parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT id_personal, id_empleados
         FROM datospersonales dp
         INNER JOIN datosempleados de
         ON dp.id_personal = de.idPersonal
         WHERE dp.cedula = ?", $parametro);
        return $sql;
    }

    // EXISTE DATOS DE PERSONAL POR CÉDULA
    private function existePersonalCD(array $parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT cedula FROM datosPersonales WHERE cedula = ?", $parametro);
        if (empty($sql)) {
            $sql = false;
        } else {
            $sql = true;
        }
        return $sql;
    }

    // EXISTE EMPELADO POR ID
    private function existeEmpleadoCD(array $parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT id_empleados FROM datosempelados WHERE id_empleados = ?", $parametro);
        if ($sql) {
            $sql = false;
        } else {
            $sql = true;
        }
        return $sql;
    }

    // existe el familiar por cedula
    public function existeFamiliarCedula(array $parametro)
    {
        $sqlCedula = $this->ejecutarConsulta("SELECT df.id_ninos, df.cedula FROM datosfamilia df WHERE df.cedula = ?", $parametro);
        if (empty($sqlCedula)) {
            // La consulta no devolvió datos o hubo un error
            return false;
        } else {
            // La consulta devolvió datos
            return true;
        }
    }

    // EXISTE FAMILIAR POR TOMO, FOLIO Y CÉDULA
    private function existeFamilar(array $parametro)
    {
        $cedula = $parametro[0];
        $tomo = $parametro[1];
        $folio = $parametro[2];

        // Primero, consulta por cédula
        $sqlCedula = $this->ejecutarConsulta("SELECT df.id_ninos, df.cedula FROM datosfamilia df WHERE df.cedula = ?", [$cedula]);

        if (!empty($sqlCedula)) {
            return [
                'mensaje' => "La cédula ya existe.",
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

    // RETORNAR FAMILIAR NO CEDULADO POR CEDULA
    public function retornaNoCedula(array $parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT df.cedula
        FROM datosfamilia df
        INNER JOIN datosempleados dt ON dt.id_empleados = df.idEmpleado
        INNER JOIN datospersonales dp ON dp.id_personal = dt.idPersonal
        WHERE dp.cedula = ? AND df.cedula LIKE ?
        ORDER BY df.id_ninos DESC LIMIT 1", $parametro);
        return $sql;
    }

    // TOTAL DE DATOS DE EMPLEADO Y DATOS PERSONALES
    private function totalDatosPE(array $parametro)
    {
        $sql = $this->ejecutarConsulta(
            "SELECT de.*, dp.*
        FROM datosEmpleados de
        INNER JOIN datosPersonales dp ON de.idPersonal = dp.id_personal
        INNER JOIN estatus e ON de.idEstatus = e.id_estatus
        INNER JOIN cargo c ON de.idCargo = c.id_cargo
        INNER JOIN dependencia depe ON de.idDependencia = depe.id_dependencia
        INNER JOIN departamento d ON de.idDepartamento = d.id_departamento WHERE dp.cedula = ?",
            $parametro
        );
        return $sql;
    }

    // TOTAL DE DATOS DE EMPLEADO Y DATOS PERSONALES POR ID PERSONAL
    private function totalDatosPEID(array $parametro)
    {
        $sql = $this->ejecutarConsulta(
            "SELECT de.*, dp.*
        FROM datosEmpleados de
        INNER JOIN datosPersonales dp ON de.idPersonal = dp.id_personal
        INNER JOIN estatus e ON de.idEstatus = e.id_estatus
        INNER JOIN cargo c ON de.idCargo = c.id_cargo
        INNER JOIN dependencia depe ON de.idDependencia = depe.id_dependencia
        INNER JOIN departamento d ON de.idDepartamento = d.id_departamento WHERE dp.id_personal = ?",
            $parametro
        );
        return $sql;
    }

    // TOTAL DE DATOS DE EMPLEADO Y DATOS PERSONALES POR CD EMPELADPO
    private function totalDatosCDEmpleados(array $parametro)
    {
        $sql = $this->ejecutarConsulta(
            "SELECT * FROM datosEmpleados de
            INNER JOIN datosPersonales dp ON de.idPersonal = dp.id_personal
            INNER JOIN estatus e ON de.idEstatus = e.id_estatus
            INNER JOIN cargo c ON de.idCargo = c.id_cargo
            INNER JOIN dependencia depe ON de.idDependencia = depe.id_dependencia
            INNER JOIN departamento d ON de.idDepartamento = d.id_departamento
            INNER JOIN ubicacion ubi ON de.id_empleados = ubi.id_empleadoUbi
              INNER JOIN estados est ON ubi.idEstado = est.id_estado
              INNER JOIN municipios m ON ubi.idMunicipio = m.id_municipio
              INNER JOIN parroquias p ON ubi.idParroquia = p.id_parroquia
            WHERE dp.cedula = ?",
            $parametro
        );
        return $sql;
    }

    // TOTAL DE DATOS DE EMPLEADO Y DATOS PERSONALES POR ID EMPLEADO
    private function totalDatosIDEmpleados(array $parametro)
    {
        $sql = $this->ejecutarConsulta(
            "SELECT * FROM datosEmpleados de
        INNER JOIN datosPersonales dp ON de.idPersonal = dp.id_personal
        INNER JOIN estatus e ON de.idEstatus = e.id_estatus
        INNER JOIN cargo c ON de.idCargo = c.id_cargo
        INNER JOIN dependencia depe ON de.idDependencia = depe.id_dependencia
        INNER JOIN departamento d ON de.idDepartamento = d.id_departamento
        WHERE de.id_empleados = ?",
            $parametro
        );
        return $sql;
    }

    //TOTAL DE DATOS DE LOS FAMILIARES
    private function totalDatosFamiliar()
    {
        $sql = $this->ejecutarConsulta(
            "SELECT *,
            df.cedula AS cedulaFamiliar,
            df.primerNombre AS primerNombreFamiliar,
            df.primerApellido AS primerApellidoFamiliar,
            dp.primerNombre AS primerNombreEmpleado,
            dp.primerApellido AS primerApellidoEmpleado
            FROM datosfamilia df
        INNER JOIN datosEmpleados de ON df.idEmpleado = de.id_empleados
        INNER JOIN datosPersonales dp ON de.idPersonal = dp.id_personal
        INNER JOIN estatus e ON de.idEstatus = e.id_estatus
        INNER JOIN cargo c ON de.idCargo = c.id_cargo
        INNER JOIN dependencia depe ON de.idDependencia = depe.id_dependencia
        INNER JOIN departamento d ON de.idDepartamento = d.id_departamento
        "
        );
        return $sql;
    }

    // DATOS DE FAMILIAR POR MEDIO ID EMPLEADO
    private function datosFamiliarEmpleadoID($parametro)
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

    // DATOS DE FAMILIAR POR MEDIO DEL ID DE FAMILIAR
    private function datosFamiliarID(array $parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT df . *,
        df.primerNombre AS primerNombreFamiliar,
        df.segundoNombre AS segundoNombreFamiliar,
        df.primerApellido AS primerApellidoFamiliar,
        df.segundoApellido AS segundoApellidoFamiliar,
        dp . cedula AS cedulaEmpleado,
        dp.primerNombre AS primerNombreEmpleado,
        dp.primerApellido AS primerApellidoEmpleado
        FROM datosfamilia df
        INNER JOIN datosempleados de
        ON de.id_empleados = df.idEmpleado
        INNER JOIN datospersonales dp ON dp.id_personal = de.idPersonal
        WHERE df.id_ninos = ? ",  $parametro);
        return $sql;
    }

    // DATOS DE PERSONAL POR FILTRO
    private function datosEmpleadoFiltro(string $clausula, array $parametro)
    {
        $sql = $this->ejecutarConsulta(
            "SELECT *, DATE_FORMAT(de.fechaING, '%d-%m-%Y') AS fechaCreada FROM datosEmpleados de
        INNER JOIN datosPersonales dp ON de.idPersonal = dp.id_personal
        INNER JOIN estatus e ON de.idEstatus = e.id_estatus
        INNER JOIN cargo c ON de.idCargo = c.id_cargo
        INNER JOIN dependencia depe ON de.idDependencia = depe.id_dependencia
        INNER JOIN departamento d ON de.idDepartamento = d.id_departamento
        INNER JOIN ubicacion ubi ON de.id_empleados = ubi.id_empleadoUbi
        INNER JOIN estados est ON ubi.idEstado = est.id_estado
        INNER JOIN municipios m ON ubi.idMunicipio = m.id_municipio
        INNER JOIN parroquias p ON ubi.idParroquia = p.id_parroquia
        WHERE $clausula",
            $parametro
        );
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

    // Total de datos de empleado
    public function totalDatosEmpleado()
    {
        $sql = $this->ejecutarConsulta("SELECT *
        FROM datosempleados de
        INNER JOIN estatus e ON de.idEstatus = e.id_estatus
        INNER JOIN cargo c ON de.idCargo = c.id_cargo
        INNER JOIN dependencia depe ON de.idDependencia = depe.id_dependencia
        INNER JOIN departamento d ON de.idDepartamento = d.id_departamento
        INNER JOIN datospersonales dp ON dp.id_personal = de.idPersonal");
        return $sql;
    }

    //contar cualquier dato
    public function contarDatos($selectores, $where, $parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT $selectores
        FROM datosEmpleados de
        INNER JOIN datosPersonales dp ON de.idPersonal = dp.id_personal
        INNER JOIN estatus e ON de.idEstatus = e.id_estatus
        INNER JOIN cargo c ON de.idCargo = c.id_cargo
        INNER JOIN dependencia depe ON de.idDependencia = depe.id_dependencia
        INNER JOIN departamento d ON de.idDepartamento = d.id_departamento
        INNER JOIN ubicacion ubi ON de.id_empleados = ubi.id_empleadoUbi
        INNER JOIN estados est ON ubi.idEstado = est.id_estado
        INNER JOIN municipios m ON ubi.idMunicipio = m.id_municipio
        INNER JOIN parroquias p ON ubi.idParroquia = p.id_parroquia
        WHERE $where", $parametro);
        return $sql;
    }

    //contar cualquier dato FAMILIAR
    public function contarDatosFamiliar($selectores, $where, $parametro)
    {
        $sql = $this->ejecutarConsulta("SELECT $selectores
            FROM datosfamilia df
            INNER JOIN datosempleados de
            ON de.id_empleados = df.idEmpleado
            INNER JOIN datospersonales dp ON dp.id_personal = de.idPersonal
        WHERE $where", $parametro);
        return $sql;
    }

    // ACTUALIZAR DATOS DE PERSONAL, EMPLEADO Y FAMILIAR
    private function actualuzarPEF($tabla, $datos, $condicion)
    {
        $sql = $this->actualizarDatos($tabla, $datos, $condicion);
        return $sql;
    }

    // ACTUALIZAR FAMILIAR POR ID DEL FAMILIAR
    public function actualuzarIDfamiliar($tabla, $datos,  $condicion)
    {
        $sql = "UPDATE $tabla SET $datos WHERE $condicion";
        $resultado = $this->ejecutarConsulta($sql);

        if ($resultado !== false) { // Verifica si es un objeto de resultado válido
            return true; // La consulta se ejecutó correctamente
        } else {
            return false; // Hubo un error en la consulta
        }
    }

    /* GETTERS */
    // GETTERS PARA REGISTRAR DATOS
    public function getRegistrar($tabla, $datos)
    {
        return $this->registrarDatos($tabla, $datos);
    }

    // REGISTRAR DOCUMENTOS
    public function getRegistrarDOCS($tabla, $datos)
    {
        return $this->registraDOCS($tabla, $datos);
    }

    // GETTER DE ACTUALIZAR DATOS
    public function getActualizar($tabla, $datos, $condicion)
    {
        return $this->actualuzarPEF($tabla, $datos, $condicion);
    }

    // GETTER DE RETORNAR ID PERSONAL POR CÉDULA
    public function getreturnIDP($parametro)
    {
        return $this->returnIDP($parametro);
    }

    // GETTER DE RETORNAR ID EMPLEADO POR CÉDULA
    public function getreturnIDPE($parametro)
    {
        return $this->returnIDPE($parametro);
    }

    // GETTER DE VALIDAR DATOS DE PERSONAL POR CÉDULA
    public function getExistePersonalCD($parametro)
    {
        return $this->existePersonalCD($parametro);
    }
    // TOTAL DE DATOS DE EMPELADOS MASIVOS EN GENERAL
    public function getTotalDatosEmpleado()
    {
        return $this->totalDatosEmpleado();
    }

    // GETTER PARA OBTENER EL TOTAL DE FAMILIARES
    public function getTotalDatosFamiliar()
    {
        return $this->totalDatosFamiliar();
    }

    // GETTER PARA OBTENER LOS DATOS DE LOS EMPELADOS POR MEDIO DEL ID
    public function getTotalDatosIDEmpleados($parametro)
    {
        return $this->totalDatosIDEmpleados($parametro);
    }

    // GETTER PARA OBTENER LOS DATOS DE UN TRABAJADOR POR MEDIO DE LA CEDULA
    public function getTotalDatosCDEmpleados($parametro)
    {
        return $this->totalDatosCDEmpleados($parametro);
    }

    // GETTER DE VALIDAR DATOS DE EMPLEADO POR CÉDULA
    public function getTotalDatosPE($parametro)
    {
        return $this->totalDatosPE($parametro);
    }

    // GETTER DE VALIDAR EXISTENCIA DE FAMILIAR
    public function getExisteFamilar($parametro)
    {
        return $this->existeFamilar($parametro);
    }

    // GETTER DE VALIDAR EXISTENCIA DE FAMILIAR POR ID
    public function getTotalDatosPEID($parametro)
    {
        return $this->totalDatosPEID($parametro);
    }

    // OBTENER FAMILIAR POR MEDIO DEL ID DEL EMPLEADO
    public function getDatosFamiliarEmpleadoID($parametro)
    {
        return $this->datosFamiliarEmpleadoID($parametro);
    }

    // OBTENER FAMILIAR POR MEDIO DEL ID
    public function getDatosFamiliarID($parametro)
    {
        return $this->datosFamiliarID($parametro);
    }

    // FILTRAR DATOS DEL TRABAJADOR
    public function getDatosEmpleadoFiltro($clausula, $parametro)
    {
        return $this->datosEmpleadoFiltro($clausula, $parametro);
    }

    // FILTAR DATOS DEL FAMILIAR
    public function getDatosFamiliarFiltro($clausula, $parametro)
    {
        return $this->datosFamiliarFiltro($clausula, $parametro);
    }
}
