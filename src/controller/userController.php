<?php

namespace App\Atlas\controller;

use App\Atlas\config\Conexion;

class userController extends Conexion
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
        // $respuesta = $this->guardarDatos("users", $usuario_datos_reg);
        // if ($respuesta->rowCount() == 1) {
        //     $alerta = array(
        //         "exit" => true,
        //         "tipo" => "registro",
        //         "titulo" => "Usuario registrado",
        //         "texto" => "El usuario " . $usuario,
        //         'mensaje' => 'Datos recibidos correctamente.'
        //     );
        // }
        $respue = $this->ejecutarConsulta("SELECT * FROM users WHERE nameUser = '$usuario'");
        if ($respue == true) {
            $alerta = array(
                "exit" => true,
                "name" => "si existe este usuario",
                "titulo" => "Usuario registrado",
                "texto" => "El usuario " . $usuario,
                'mensaje' => 'Datos recibidos correctamente.'
            );
        }
        // Enviar la respuesta como JSON
        header('Content-Type: application/json');
        echo json_encode($alerta);
    }
}
