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
            $datos_json = array();
            foreach ($respue as $usuario2) {
                    $datos_json = array(
                        'exito' => true,
                        'nombre' => $usuario2['nameUser'],
                        'passwordAlmacenado' => $usuario2['userPassword'],
                        'passwordEnviado'=> $password,
                        'mensaje' => 'Datos recibidos correctamente.'
                        // Agrega más campos según tu estructura de datos
                    );
                }
            }
        header('Content-Type: application/json');
        echo json_encode($datos_json);
    }
}
