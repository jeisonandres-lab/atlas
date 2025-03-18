<?php

namespace App\Atlas\models;

use App\Atlas\config\Conexion;

class userModel extends Conexion
{

    private function existeUsuario(string $user)
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
         FROM users us INNER JOIN rol r ON us.idRol = r.id_rol WHERE us.nameUser = '$user'");
        return $sql;
    }

    private function datosUsuario($user): string
    {
        $sql = $this->ejecutarConsulta("SELECT * FROM users WHERE nameUser = '.$user.'");
        return $sql;
    }

    private function pinSeguridad(array $parametros)
    {
        $sql = $this->ejecutarConsulta("SELECT us.pin, dtp.cedula FROM users us INNER JOIN datosempleados dte ON us.idEmpleado = id_empleados
        INNER JOIN datospersonales dtp ON dte.idPersonal = dtp.id_personal WHERE us.pin = ? AND dtp.cedula = ? ", $parametros);
        if (empty($sql)) {
            return false;
        } else {
            return $sql;
        }
    }

    private function actulizarDato($tabla, $datos, $condicion)
    {
        $sql = $this->actualizarDatos($tabla, $datos, $condicion);
        return $sql;
    }
    public function getExisteUsuario($user)
    {
        return $this->existeUsuario($user);;
    }

    public function getDatosUsuario($user)
    {
        return $this->datosUsuario($user);
    }

    public function getActualizarDato($tabla, $datos, $condicion)
    {
        return $this->actulizarDato($tabla, $datos, $condicion);
    }


    // valdiar el pin de seguridad del usuario
    public function getPinSeguridad(array $parametros)
    {
        return $this->pinSeguridad($parametros);
    }
}
