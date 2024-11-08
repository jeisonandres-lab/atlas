<?php

namespace App\Atlas\controller;
use App\Atlas\config\Conexion;

class  loginController extends Conexion {

    public function logearse(string $user, string $password){
        $data_json = [
            'exito' => false, // Inicializamos a false por defecto
            'mensaje' => ''
        ];

        if (empty($user) || empty($password)) {
            $data_json['mensaje'] = 'La contraseña o el usuario no fueron colocados.';
        }else{
            if ($resputa = $this->verificarDatos("[a-zA-Z0-9]{8,20}", $user)) {
                $data_json['mensaje'] = 'el usuario no cumple con lo solicitado, debe de tener minimo 8 caracteres.';
                $data_json['usuario'] = $resputa;
            }else{
                $check_user = $this->ejecutarConsulta("SELECT * FROM users WHERE nameUser = '$user'");
                if ($check_user == true) {
                    foreach ($check_user as $row) {
                        if($row['nameUser'] === $user){
                            $data_json['exito'] = true;
                            $data_json['mensaje'] = 'Usuario encontrado con exito';
                            $data_json['id'] = $row['id_user'];
                            $data_json['usuario'] = $row['nameUser'];
                            $data_json['password'] = $row['userPassword'];
                        }else{
                            $data_json['mensaje'] = 'Usuario no coincide';
                        }
                    }
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function inicioSession (string $user, bool $password){

    }


}