<?php

namespace App\Atlas\controller;

use App\Atlas\models\userModel;
use App\Atlas\config\App;
use App\Atlas\models\tablasModel;

class  userController extends userModel
{

    private $app2;

    private $app;
    private $tablas;
    public function __construct()
    {
        parent::__construct();
        $this->app = new App();
        $this->tablas = new tablasModel();
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

    public function DatosUsuariosBasicos()
    {
        $data_json['data'] = []; // Array de datos para enviar
        $tabla = 'users INNER JOIN rol ON users.idRol = rol.id_rol'; // Tabla a consultar
        $selectoresCantidad = 'COUNT(id_user) as cantidad'; // Selector para contar la cantidad de registros de la tabla
        $datosBuscar = []; // Array de selectores para buscar en la tabla
        $campoOrden = 'id_user'; // Campo por el cual se ordenará la tabla
        $selectores = '*'; // Selectores para obtener los datos de la tabla
        $conditions = []; // Condiciones para obtener los datos de la tabla
        $conditionParams = []; // Parámetros de las condiciones

        $draw = $_REQUEST['draw'];
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $searchValue = $_REQUEST['search']['value'];

        // Obtener la cantidad de los datos de la tabla
        $cantidadRegistro = $this->tablas->getCantidadRegistros($tabla, $selectoresCantidad, $conditions, $conditionParams);
        // Obtener los datos de la tabla
        $personal = $this->tablas->getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden, $conditions, $conditionParams);
        // Recorrer datos de la tabla

        foreach ($personal as $row) {
            $data_json['data'][] = [
                '0' => $row['enUso'],
                '1' => $row['nameUser'],
                '2' => $row['rol'],
                '3' => $row['activo'],
            ];
            $data_json['mensaje'] = "todas las dependencias de manera exitosa";
        }

        // Devolver la respuesta a DataTables
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $cantidadRegistro[0]['cantidad'],
            "recordsFiltered" => $cantidadRegistro[0]['cantidad'],
            "data" => $data_json['data']
        );
        header('Content-Type: application/json');
        echo json_encode($response);
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
