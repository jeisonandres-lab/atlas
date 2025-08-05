<?php

namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';

use App\Atlas\config\EjecutarSQL;
use App\Atlas\controller\unidadOrganizacional\DependenciasController;
use App\Atlas\controller\unidadOrganizacional\DepartamentoController;
use App\Atlas\controller\unidadOrganizacional\CargoController;
use App\Atlas\controller\unidadOrganizacional\EstatusController;
use App\Atlas\config\peticiones;

$peticionHandler = new peticiones();
// variables estraidas
$variables = $peticionHandler->obtenerVariables();
extract($variables);


// $id= isset($_POST['id']) ? $conexion->limpiarCadena($_POST['id']) : "";
// $activo = isset($_POST['activo']) ? $conexion->limpiarCadena($_POST['activo']) : "";

// //DATOS DE DEPENDENCIA
// $nombredepen = isset($_POST['dependencia']) ? $conexion->limpiarCadena($_POST['dependencia']) : "";
// $codigodepen = isset($_POST['codigo']) ? $conexion->limpiarCadena($_POST['codigo']) : "";
// $estadodepen = isset($_POST['estado']) ? $conexion->limpiarCadena($_POST['estado']) : "";

// //DATOS DE CARGO
// $nombreCargo = isset($_POST['cargo']) ? $conexion->limpiarCadena($_POST['cargo']) : "";

// //DATOS DE ESTATUS

// $nombreEstatus = isset($_POST['estatus']) ? $conexion->limpiarCadena($_POST['estatus']) : "";

// //DATOS DE DEPARTAMENTO
// $nombreDepartamento = isset($_POST['departamento']) ? $conexion->limpiarCadena($_POST['departamento']) : "";

// switch ($_GET['modulo_datos']) {
//     //cambiar a dependencia
//     case 'obtenerDatosDepe':
//         $dependencias->datosDependencia();
//         break;
//     case 'obtenerDatosCargo':
//         $cargo->datosCargo();
//         break;
//     case 'obtenerDatosEstatus':
//         $estatus->datosEstatus();
//         break;
//     case 'obtenerDatosDepartamento':
//         $departamento->datosDepartamento();
//         break;

//     case 'obtenerEstados':
//         $dependencias->datosEstado();
//         break;
//     case 'agregarDependencia':
//         $dependencias->regisDependencia($nombredepen, $codigodepen, $estadodepen);
//         break;
//     case 'agregarEstatus':
//         $estatus->regisEstatus($nombreEstatus);
//         break;
//     case 'agregarCargo':
//         $cargo->regisCargo($nombreCargo);
//         break;
//     case 'agregarDepartamento':
//         $departamento->regisDepartamento($nombreDepartamento);
//         break;
//     case 'obtenerDependencia':
//         $dependencias->dependencia($id);
//         break;
//     case 'editarDependencia':
//         $dependencias->editarDependencia($id, $nombredepen, $codigodepen, $estadodepen);
//         break;
//     case 'editarCargo':
//         $cargo->editarCargo($id, $nombreCargo);
//         break;
//     case 'editarEstatus':
//         $estatus->editarEstatus($id, $nombreEstatus);
//         break;
//     case 'editarDepartamento':
//         $departamento->editarDepartamento($id, $nombreDepartamento);
//         break;
//     case 'eliminarActivarDependencia':
//         $dependencias->eliminarActivarDependencia($id, $activo);
//         break;
//     case 'eliminarActivarCargo':
//         $cargo->eliminarActivarCargo($id, $activo);
//         break;
//     case 'eliminarActivarEstatus':
//         $estatus->eliminarActivarEstatus($id, $activo);
//         break;
//     case 'eliminarActivarDepartamento':
//         $departamento->eliminarActivarDepartamento($id, $activo);
//         break;

//     default:
//         break;
// }


class RouterUnidadOrganizacional {
    private $routes = [];
    private $dependencias;
    private $departamento;
    private $cargo;
    private $estatus;


    public function __construct() {
        $this->dependencias = new DependenciasController();
        $this->estatus = new EstatusController();
        $this->cargo = new CargoController();
        $this->departamento = new DepartamentoController();
        $this->registerRoutes();
    }

    private function registerRoutes() {
        //Trae todos los datos en general de la tabla
        $this->add('obtenerDependenciaGeneral', function() {
            $this->dependencias->obtenerdependeciasGeneral();
        });

        $this->add('obtenerEstatusGeneral', function() {
            $this->estatus->obtenerEstatusGeneral();
        });

        $this->add('obtenerCargoGeneral', function() {
            $this->cargo->obtenerCargoGeneral();
        });

        $this->add('obtenerDepartamentoGeneral', function() {
            $this->departamento->obtenerDeparmatentoGeneral();
        });

        //Datos Obtenedor para tablas de Datatablets
        $this->add('obtenerDatosDepe', function() {
            $this->dependencias->datosDependencia();
        });
        $this->add('obtenerDatosCargo', function() {
            $this->cargo->datosCargo();
        });
        $this->add('obtenerDatosEstatus', function() {
            $this->estatus->datosEstatus();
        });
        $this->add('obtenerDatosDepartamento', function() {
            $this->departamento->datosDepartamento();
        });
        $this->add('obtenerEstados', function() {
            $this->dependencias->datosEstado();
        });

        // Registra todos los datos respectivos
        $this->add('agregarDependencia', function() {
            global $nombredepen, $codigodepen, $estadodepen;
            $this->dependencias->regisDependencia($nombredepen, $codigodepen, $estadodepen);
        });
        $this->add('agregarEstatus', function() {
            global $nombreEstatus;
            $this->estatus->regisEstatus($nombreEstatus);
        });
        $this->add('agregarCargo', function() {
            global $nombreCargo;
            $this->cargo->regisCargo($nombreCargo);
        });
        $this->add('agregarDepartamento', function() {
            global $nombreDepartamento;
            $this->departamento->regisDepartamento($nombreDepartamento);
        });

        // Obtener los datos por medio de id
        $this->add('obtenerDependencia', function() {
            global $id;
            $this->dependencias->dependencia($id);
        });

        //Editar los datos
        $this->add('editarDependencia', function() {
            global $id, $nombredepen, $codigodepen, $estadodepen;
            $this->dependencias->editarDependencia($id, $nombredepen, $codigodepen, $estadodepen);
        });
        $this->add('editarCargo', function() {
            global $id, $nombreCargo;
            $this->cargo->editarCargo($id, $nombreCargo);
        });
        $this->add('editarEstatus', function() {
            global $id, $nombreEstatus;
            $this->estatus->editarEstatus($id, $nombreEstatus);
        });
        $this->add('editarDepartamento', function() {
            global $id, $nombreDepartamento;
            $this->departamento->editarDepartamento($id, $nombreDepartamento);
        });
        $this->add('eliminarActivarDependencia', function() {
            global $id, $activo;
            $this->dependencias->eliminarActivarDependencia($id, $activo);
        });

        // Eliminar los datos
        $this->add('eliminarActivarCargo', function() {
            global $id, $activo;
            $this->cargo->eliminarActivarCargo($id, $activo);
        });
        $this->add('eliminarActivarEstatus', function() {
            global $id, $activo;
            $this->estatus->eliminarActivarEstatus($id, $activo);
        });
        $this->add('eliminarActivarDepartamento', function() {
            global $id, $activo;
            $this->departamento->eliminarActivarDepartamento($id, $activo);
        });
    }

    public function add($key, $callback) {
        $this->routes[$key] = $callback;
    }

    public function dispatch($key) {
        if (isset($this->routes[$key])) {
            call_user_func($this->routes[$key]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Acción no encontrada']);
        }
    }
}

if (!isset($_GET['modulo_datos'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Falta el parámetro modulo_unidad']);
    exit;
}

// App::zonaHoraria(); // Establece la zona horaria

$router = new RouterUnidadOrganizacional();
$router->dispatch($_GET['modulo_datos']);