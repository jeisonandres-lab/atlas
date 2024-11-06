<?php

namespace App\Atlas\controller;

use App\Atlas\config\Conexion;

class userController extends Conexion
{
    public function hola(){
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
        $respuesta = $this->guardarDatos("users", $usuario_datos_reg);
        if ($respuesta->rowCount() == 1) {
            $alerta = [
                "exit" => true,
                "tipo" => "registro",
                "titulo" => "Usuario registrado",
                "texto" => "El usuario " . $usuario
            ];
        }
        // Enviar la respuesta como JSON
        header('Content-Type: application/json');
        echo json_encode($alerta);

    }
}
