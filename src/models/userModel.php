<?php
namespace App\Atlas\models;
use App\Atlas\config\Conexion;

class userModel extends Conexion {

    private function existeUsuario(string $user){
        $sql = $this->ejecutarConsulta("SELECT id_user, nameUser, userPassword, activo FROM users WHERE nameUser = '$user'");
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