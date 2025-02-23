<?php
namespace App\Atlas\models;
use App\Atlas\config\Conexion;

class userModel extends Conexion {

    private function existeUsuario(string $user){
        $sql = $this->ejecutarConsulta("SELECT
         us.id_user,
         us.nameUser as nameUser,
         us.userPassword as userPassword,
         us.activo as activo,
         us.idRol as idrol,
         us.permiso as permiso,
         r.rol as rol
         FROM users us INNER JOIN rol r ON us.idRol = r.id_rol WHERE us.nameUser = '$user'");
        return $sql;
    }

    private function datosUsuario($user):string{
        $sql = $this->ejecutarConsulta("SELECT * FROM users WHERE nameUser = '.$user.'");
        return $sql;
    }

    public function getExisteUsuario($user){
        return $this->existeUsuario($user);;
    }

    public function getDatosUsuario($user){
        return $this->datosUsuario($user);
    }





}