<?php

namespace App\Atlas\config;

use App\Atlas\controller\sistema\ViewController;
use App\Atlas\config\HoraLocal;

class Aplicacion
{
    private $app;
    private $viewsController;
    private $horaLocal;
    private $rutasPublicas = [
        'Identificarse',
        'recuperarDatos',
        'login',
        'horario',
        'test',
    ];

    public function __construct()
    {
        $this->app = new App();
        $this->viewsController = new ViewController();
        $this->horaLocal = new HoraLocal();
    }

    /**
     * Inicializa la aplicación
     */
    public function run()
    {
        // Procesar URL y obtener vista
        $vista = $_GET['vista'] ?? 'login';
        $url = $_SERVER['REQUEST_URI'];
        $datosURL = $this->app->analizarURL($url);
        $parametros = $datosURL['parametros'] ?? null;

        // Obtener la vista correspondiente
        $vista2 = $this->viewsController->obtenerVistasControlador($vista);

        // Verificar si la ruta actual es pública
        if ($this->esRutaPublica($vista)) {
            require_once $vista2;
            return;
        }
        // Para rutas protegidas, inicializar sesión y verificar autenticación
        session_start();
        if ($this->estaAutenticado()) {
            $this->cargarVistaProtegida($vista2);
        } else {
            $this->app->redirigirALogin();
        }
    }

    /**
     * Verifica si la ruta es pública
     * @param string $vista
     * @return bool
     */
    private function esRutaPublica(string $vista): bool
    {
        return in_array($vista, $this->rutasPublicas);
    }

    /**
     * Verifica si el usuario está autenticado
     * @return bool
     */
    private function estaAutenticado(): bool
    {
        return isset($_SESSION['usuario']) && !empty($_SESSION['usuario']);
    }

    /**
     * Carga una vista protegida con los datos del usuario
     * @param string $vista2
     */
    private function cargarVistaProtegida(string $vista2)
    {
        require_once $vista2;
    }
}