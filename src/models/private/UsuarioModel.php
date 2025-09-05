<?php

namespace App\Atlas\models\private;

use App\Atlas\config\EjecutarSQL;

class UsuarioModel extends EjecutarSQL
{

    public function existeUsuario($user)
    {
        $sql = $this->ejecutarConsulta("SELECT
         us.id_user,
         us.nameUser as nameUser,
         us.userPassword as userPassword,
         us.saltPass as saltPass,
         us.activo as activo,
         us.idRol as idrol,
         us.permiso as permiso,
         r.rol as rol
         FROM users us INNER JOIN rol r ON us.idRol = r.id_rol WHERE us.nameUser = ?", [$user]);
        return $sql;
    }

    protected function datosUsuario($user): string
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM users WHERE nameUser = ?", [$user]);
        return $sql;
    }

    protected function pinSeguridad(array $parametros)
    {
        $sql = $this->ejecutarConsulta("SELECT us.pin, dtp.cedula FROM users us INNER JOIN datosempleados dte ON us.idEmpleado = id_empleados
        INNER JOIN datospersonales dtp ON dte.idPersonal = dtp.id_personal WHERE us.pin = ? AND dtp.cedula = ? ", $parametros);
        if (empty($sql)) {
            return false;
        } else {
            return $sql;
        }
    }

    protected function actulizarDato($tabla, $datos, $condicion)
    {
        $sql = $this->actualizarDatos($tabla, $datos, $condicion);
        return $sql;
    }
}
