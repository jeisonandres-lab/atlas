<?php

namespace App\Atlas\controller;

use App\Atlas\models\userModel;
use App\Atlas\config\App;

class  userController extends userModel
{

    private $app2;

    private $app;

    public function __construct()
    {
        parent::__construct();
        $this->app = new App();
    }
    public function logearse(string $user, string $password)
    {
        $data_json = [
            'exito' => false, // Inicializamos a false por defecto
            'mensaje' => ''
        ];

        if (empty($user) || empty($password)) {
            $data_json['mensaje'] = 'La contraseña o el usuario no fueron colocados.';
        } else {
            if ($resputa = $this->verificarDatos("[a-zA-Z0-9]{8,20}", $user)) {
                $data_json['mensaje'] = 'el usuario no cumple con lo solicitado, debe de tener minimo 8 caracteres.';
                $data_json['usuario'] = $resputa;
            } else {
                $check_user = $this->getExisteUsuario($user);
                if ($check_user == true) {

                    session_start();
                    foreach ($check_user as $row) {
                        if ($row['nameUser'] === $user) {
                            $data_json['exito'] = true;
                            $data_json['usuario'] = $row['nameUser'];
                            $data_json['mensaje'] = 'Usuario encontrado con exito';
                            $data_json['password'] = $row['userPassword'];
                            $data_json['activo'] = 'desactivado';

                            $_SESSION['usuario'] = $user;
                            $_SESSION['id'] = $row['id_user'];
                            $_SESSION['activado'] = $row['activo'];
                        } else {
                            $data_json['mensaje'] = 'Usuario no coincide';
                        }
                    }
                } else {
                    $data_json["mensaje"] = "El usuario no existe";
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function redireccionarUsuario($url)
    {
        if ($url) {
            $datos = [
                'url' => $url
            ];
            header('Content-Type: application/json');
            echo json_encode($datos);
        } else {
        }
    }

    public function cerrarSession_total($url){
        $this->app->cerrarSession();
        if ($url) {
            $datos = [
                'url' => $url
            ];
            header('Content-Type: application/json');
            echo json_encode($datos);
        } else {
        }
    }

    public function getApp()
    {
        return $this->app2 = new App();
    }

    public function getIniciarSession()
    {
        $appuser = $this->getApp();
        return $appuser->iniciarSession();
    }

    public function getIniciarName()
    {
        $appuser = $this->getApp();
        return $appuser->iniciarName();
    }
}
