<?php

namespace App\Atlas\controller;

use App\Atlas\models\UserModel;
use App\Atlas\config\App;
use App\Atlas\models\TablasModel;
use App\Atlas\controller\AuditoriaController;

class  UserController extends UserModel
{

    private $app2;
    private $auditoriaController;
    private $app;
    private $tablas;

    public function __construct()
    {
        parent::__construct();
        $this->app = new App();
        $this->tablas = new TablasModel();
        $this->auditoriaController = new AuditoriaController();
    }

    /**
     * Inicia sesión
     * @param string $user
     * @param string $password
     * @return array
     */
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
                            $data_json['salt'] = $row['saltPass'];
                            $data_json['activo'] = 'desactivado';

                            $_SESSION['usuario'] = $user;
                            $_SESSION['id'] = $row['id_user'];
                            $_SESSION['activado'] = $row['activo'];
                            $_SESSION['idrol'] = $row['idrol'];
                            $_SESSION['rol'] = $row['rol'];
                            $_SESSION['permiso'] = $row['permiso'];

                            $id =  $_SESSION['id'];
                            $usuario = $_SESSION['usuario'];

                            $registroAuditoria = $this->auditoriaController->registrarAuditoria($id, 'Inicio de sesion', 'el usuario' . ' ' . $usuario . ' a iniciado sesion en el sistema');
                            if ($registroAuditoria) {
                                $data_json["exitoAuditoria"] = true;
                                $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                            } else {
                                $data_json["exito"] = false;
                                $data_json['messenger'] = "Error al registrar la auditoria.";
                            }
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

    public function cerrarSession_total($url)
    {
        $this->app->cerrarSession();
        $id =  $_SESSION['id'];
        $usuario = $_SESSION['usuario'];
        $registroAuditoria = $this->auditoriaController->registrarAuditoria($id, 'cierre de sesion', 'el usuario' . ' ' . $usuario . ' a cerrado sesion en el sistema');
        if ($registroAuditoria) {
            $data_json["exitoAuditoria"] = true;
            $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
        } else {
            $data_json["exito"] = false;
            $data_json['messenger'] = "Error al registrar la auditoria.";
        }
        if ($url) {
            $datos = [
                'url' => $url
            ];
        } else {
        }
        header('Content-Type: application/json');
        echo json_encode($datos);
    }

    public function datosUsuariosBasicos()
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
        $personal = $this->tablas->getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden, $conditions, $conditionParams, $ordenTabla = 'ASC');
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


    public function datosUsuarios()
    {
        $data_json['data'] = []; // Array de datos para enviar
        $tabla = 'users us
        INNER JOIN datosempleados dp ON us.idEmpleado = dp.id_empleados
        INNER JOIN datospersonales dpe ON dp.idPersonal = dpe.id_personal INNER JOIN cargo ca ON dp.idCargo = ca.id_cargo
        INNER JOIN rol r ON us.idRol = r.id_rol'; // Tabla a consultar
        $selectoresCantidad = 'COUNT(id_cargo) as cantidad'; // Selector para contar la cantidad de registros de la tabla
        $datosBuscar = ['nameUser']; // Array de selectores para buscar en la tabla
        $campoOrden = 'id_user'; // Campo por el cual se ordenará la tabla
        $selectores = '*, us.activo AS activoUser'; // Selectores para obtener los datos de la tabla
        $conditions = []; // Condiciones para obtener los datos de la tabla
        $conditionParams = []; // Parámetros de las condiciones

        $draw = $_REQUEST['draw'];
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $searchValue = $_REQUEST['search']['value'];

        // Obtener la cantidad de los datos de la tabla
        $cantidadRegistro = $this->tablas->getCantidadRegistros($tabla, $selectoresCantidad, $conditions, $conditionParams);
        // Obtener los datos de la tabla
        $personal = $this->tablas->getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden, $conditions, $conditionParams, $ordenTable = 'DESC');
        // Recorrer datos de la tabla

        foreach ($personal as $row) {

            if ($row['enUso'] == 0) {
                $row['enUso'] = 'No';
            } else {
                $row['enUso'] = 'Si';
            }
            $buttons = "

               ";
            if ($row['activo'] == 0) {
                $buttons .= "
                <button class='btn btn-success btn-sm btn-hover-verde btnActivarCargo ' data-id='" . $row['id_user'] . "'><i class='fa-solid fa-check fa-sm me-2'></i>Activar</button>
                ";
            } else {
                $buttons .= "
                <button class='btn btn-danger btn-sm btn-hover-rojo btnEliminarUsuario' data-swal-toast-template='#my-template' data-id=" . $row['id_user'] .  "><i class='fa-solid fa-trash fa-sm me-2'></i>Desactivar</button>
                ";
            }
            $data_json['data'][] = [
                '0' => $row['activoUser'],
                '1' => $row['cedula'],
                '2' => $row['nameUser'],
                '3' => $row['rol'],
                '4' => $row['enUso'],
                '5' => $buttons,
            ];
            $data_json['mensaje'] = "todas las cargos de manera exitosa";
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

    public function desactivarUsuario($id)
    {
        $data_json = [
            'exito' => false, // Inicializamos a false por defecto
            'mensaje' => ''
        ];
        $parametros = [
            [
                "campo_nombre" => "activo",
                "campo_marcador" => ":activo",
                "campo_valor" => 2
            ],

        ];

        $condicion = [
            "condicion_campo" => "id_user",
            "condicion_marcador" => ":id_user",
            "condicion_valor" => $id
        ];

        $desactivar = $this->getActualizarDato('users', $parametros, $condicion);
        if ($desactivar) {
            $data_json['exito'] = true;
            $data_json['mensaje'] = 'Usuario desactivado con exito';
        } else {
            $data_json['mensaje'] = 'Error al desactivar el usuario';
        }
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }


}
