<?php

namespace App\Atlas\models\private;

use App\Atlas\config\Error;
use App\Atlas\config\App;

class ViewModel extends Error
{
    private $app;

    public function __construct()
    {
        // Constructor de la clase
        // Aquí puedes inicializar propiedades o realizar configuraciones necesarias
        $this->app = new App();
    }

    /*---------- Modelo obtener vista ----------*/
    /*
    * @param string $vista - Obtener nombre de la vista
    * @return string - Retorna la ruta de la vista
    */
    protected function obtenerVistasModelo($vista)
    {
        Error::captureError();

        // Configuración de rutas absolutas de vistas
        $vistas = [
            // Inicio
            'inicio' => __DIR__ . '/../../views/inicio/home.php',
            // Datos Empleados
            'RegistrarEmpleado' => __DIR__ . '/../../views/empleado/registrarEmpleado.php',
            'Empleados' => __DIR__ . '/../../views/empleado/registrosEmpleados.php',
            'datosInces' => __DIR__ . '/../../views/empleado/DatosInces.php',

            // Datos Familiares
            'RegistrarFamiliares' => __DIR__ . '/../../views/familiar/registrarFamiliar.php',
            'Familiares' => __DIR__ . '/../../views/familiar/registrosFamiliares.php',
            // Bienestar Social
            'ficha' => __DIR__ . '/../../views/bienestarSocial/fichaTecnica.php',
            // Vacaciones
            'ausencia' => __DIR__ . '/../../views/ausencia/ausencia.php',
            'vacaciones' => __DIR__ . '/../../views/ausencia/vacaciones.php',
            // Administrador
            'HistorialUsuarios' => __DIR__ . '/../../views/administrador/historialUsuarios.php',
            'RegistrosUsuarios' => __DIR__ . '/../../views/administrador/registrosUsuarios.php',
            // Publico
            'horario' => __DIR__ . '/../../views/publico/horario.php',
            'Identificarse' => __DIR__ . '/../../views/publico/login.php',
            'recuperarDatos' => __DIR__ . '/../../views/publico/recuperar.php',
            'error' => __DIR__ . '/../../error/error.html',
            'test' => __DIR__ . '/../../views/test_session.php',
            'datosPersonal' => __DIR__ . '/../../views/bienestarSocial/datosPersonal.php',

        ];

        // Obtener la ruta completa de la vista
        $rutaVista = $vistas[$vista] ?? null;

        // Verificar si la ruta existe y retornar la ruta o un 404
        if ($rutaVista && file_exists($rutaVista)) {
            return $rutaVista;
        } elseif ($vista == "Identificarse" || $vista == "index") {
            return __DIR__ . '/../views/publico/login.php'; // Ruta absoluta a Identificarse
        } else {
            Error::captureError("Vista no encontrada: $vista");
            header("Location: " . App::APP_URL . "Identificarse");
            exit;
        }
    }
}
