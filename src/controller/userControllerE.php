<?php

namespace App\Atlas\controller;

use App\Atlas\config\Conexion;

class userControllerww extends Conexion
{
    public function hola()
    {

        $usuario = $this->limpiarCadena($_POST['usuario']);
        $password = $this->limpiarCadena($_POST['password']);

        $usuario_datos_reg = [
            [
                "campo_nombre" => "nameUser",
                "campo_marcador" => ":Nombre",
                "campo_valor" => $usuario
            ],
            [
                "campo_nombre" => "userPassword",
                "campo_marcador" => ":password",
                "campo_valor" => $password
            ]
        ];
    }

}
