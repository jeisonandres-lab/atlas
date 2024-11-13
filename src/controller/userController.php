<?php

namespace App\Atlas\controller;
use App\Atlas\models\userModel;
use App\Atlas\config\App;

class  userController extends userModel  {

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
                $check_user = $this->getExisteUsuario($user);
                if ($check_user == true) {
                    foreach ($check_user as $row) {
                        if($row['nameUser'] === $user){
                            $data_json['exito'] = true;
                            $data_json['usuario'] = $row['nameUser'];
                            $data_json['mensaje'] = 'Usuario encontrado con exito';
                            $data_json['password'] = $row['userPassword'];
                            $data_json['activo'] = 'desactivado';
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

    public function redireccionarUsuario($url){
        if($url){
            $datos = [
                'url' => $url
            ];
            header('Content-Type: application/json');
            echo json_encode($datos);
        }else{

        }
    }

    // public function iniciarSession($user){
    //     session_name();
    //     session_start();



    // }

    public function cerrarSession(){
        session_destroy();
    }


}

