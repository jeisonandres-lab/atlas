<?php

namespace  App\Atlas\models;

use App\Atlas\config\Conexion;

class NotificacionModel extends Conexion
{
    public function __construct()
    {
        parent::__construct();
    }

    private function generarNotificacion($tabla, $datos)
    {
        $sql = $this->guardarDatos($tabla, $datos);
        return $sql;
    }

    public function getGenerarNotificacion($tabla, $datos)
    {
        $sql = $this->generarNotificacion($tabla, $datos);
        return $sql;
    }

    public function buscarNotiRol($parametros)
    {
        $sql = $this->ejecutarConsulta("SELECT noti.* FROM notificaciones noti
        WHERE noti.userRol = ? AND noti.fecha = ?
        ORDER BY noti.id_noti DESC
        LIMIT 3", $parametros);
        return $sql;
    }

    public function contarNotiRol($parametros)
    {
        $sql = $this->ejecutarConsulta("SELECT COUNT(noti.userRol) as contarNotificacion FROM notificaciones noti
        WHERE noti.userRol = ? AND noti.fecha = ?
        ORDER BY noti.id_noti DESC
        LIMIT 3", $parametros);
        return $sql;
    }
}
