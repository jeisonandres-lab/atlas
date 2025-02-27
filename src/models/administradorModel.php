<?php

namespace App\Atlas\models;

use App\Atlas\config\Conexion;

class administradorModel extends Conexion
{


    public function  totaldatosMasivosUsuario(array $parametros)
    {
        $sql = $this->ejecutarConsulta("SELECT
        us.nameUser,
        dtp.primerNombre,
        dtp.primerApellido,
        dtp.cedula,
        c.cargo,
        au.codigo,
        au.tipo_evento,
        DATE_FORMAT(au.fecha, '%d/%m/%Y') AS fechaCreada,
        au.hora,
        au.ip,
        au.descripcion
        FROM auditoria au
        INNER JOIN users us ON au.user_id = us.id_user
        INNER JOIN datosempleados dte ON us.idEmpleado = id_empleados
        INNER JOIN cargo c ON dte.idCargo = c.id_cargo
        INNER JOIN datospersonales dtp ON dte.idPersonal = dtp.id_personal
        WHERE BINARY us.nameUser = ? ORDER BY au.id_auditoria DESC ", $parametros);

        if ($sql) {
            return $sql;
        } else {
            return false;
        }
    }

    public function  totaldatosMasivosTodoUsuarios()
    {
        $sql = $this->ejecutarConsulta("SELECT
        us.nameUser,
        dtp.primerNombre,
        dtp.primerApellido,
        dtp.cedula,
        c.cargo,
        au.codigo,
        au.tipo_evento,
        DATE_FORMAT(au.fecha, '%d/%m/%Y') AS fechaCreada,
        au.hora,
        au.ip,
        au.descripcion
        FROM auditoria au
        INNER JOIN users us ON au.user_id = us.id_user
        INNER JOIN datosempleados dte ON us.idEmpleado = id_empleados
        INNER JOIN cargo c ON dte.idCargo = c.id_cargo
        INNER JOIN datospersonales dtp ON dte.idPersonal = dtp.id_personal");
        if ($sql) {
            return $sql;
        } else {
            return false;
        }
    }

    public function  totaldatosMasivosTodoUsuariosTIPOEVENTO(array $parametros)
    {
        $sql = $this->ejecutarConsulta("SELECT
            us.nameUser,
            dtp.primerNombre,
            dtp.primerApellido,
            dtp.cedula,
            c.cargo,
            au.codigo,
            au.tipo_evento,
            DATE_FORMAT(au.fecha, '%d/%m/%Y') AS fechaCreada,
            au.hora,
            au.ip,
            au.descripcion
            FROM auditoria au
            INNER JOIN users us ON au.user_id = us.id_user
            INNER JOIN datosempleados dte ON us.idEmpleado = id_empleados
            INNER JOIN cargo c ON dte.idCargo = c.id_cargo
            INNER JOIN datospersonales dtp ON dte.idPersonal = dtp.id_personal
            WHERE au.tipo_evento LIKE ?",$parametros);

        if ($sql) {
            return $sql;
        } else {
            return $sql;
        }
    }
}
