<?php

require_once '../../vendor/autoload.php';

use App\Atlas\controller\estadistica\TotalEstadisticaController;
use App\Atlas\config\App;

header('Content-Type: application/json');

class RouterEstadistica {
    private $routes = [];
    private $controllerEstadisticas;

    public function __construct() {
        $this->controllerEstadisticas = new TotalEstadisticaController();
        $this->registerRoutes();
    }

    private function registerRoutes() {
        $this->add('totalDatos', function() { 
            $this->controllerEstadisticas->totalDatosCard(); 
        });
        $this->add('totalArchivosMes', function() { 
            $this->controllerEstadisticas->totalArchivosMes(); 
        });
        $this->add('totalArchivosDia', function() { 
            $this->controllerEstadisticas->totalArchivosDia(); 
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

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

if (!isset($_GET['modulo_Datos'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Falta el parámetro modulo_Datos']);
    exit;
}

App::zonaHoraria(); // Establece la zona horaria

$router = new RouterEstadistica();
$router->dispatch($_GET['modulo_Datos']);






/*
$controller = new TotalEstadisticaController();
$router = new Router();

$router->add('totalDatos', function() use ($controller) { $controller->totalDatosCard(); });
$router->add('totalArchivosMes', function() use ($controller) { $controller->totalArchivosMes(); });
$router->add('totalArchivosDia', function() use ($controller) { $controller->totalArchivosDia(); });

$router->dispatch($_GET['modulo_Datos']);

class Router {
    private $routes = [];

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
}*/