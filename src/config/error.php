<?php

namespace App\Atlas\config;

use App\Atlas\config\App;

class error extends App
{
    private $errorReportingLevel = -1;
    private $ignoreRepeatedErrors = TRUE;
    private $displayErrors = FALSE;
    private $logErrors = TRUE;
    private $errorLogFile = "./php-error.log";

    public function __construct() {}

    private function configuracion()
    {

        App::zonaHoraria();
        error_reporting($this->errorReportingLevel); // Informe de errores: informe todos los errores excepto los avisos
        ini_set('ignore_repeated_errors', $this->ignoreRepeatedErrors); // Ignorar errores repetidos: siempre use TRUE
        ini_set('display_errors', $this->displayErrors); // Mostrar errores: use FALSE solo en entornos de producción o servidores reales. Use TRUE en entornos de desarrollo
        ini_set('log_errors', $this->logErrors); // Registrar errores en archivo: activar el registro de errores en un archivo
        ini_set("error_log", $this->errorLogFile); // Ruta del archivo de registro de errores: especificar la ruta del archivo donde se registrarán los errores
        // error_log("Hello, errors!"); // Registrar mensaje de error: registrar un mensaje de error personalizado
        ob_start();
        set_exception_handler(function ($exception) use (&$haOcurridoUnError) {
            $haOcurridoUnError = true;
            // Crear un mensaje de error detallado
            $mensajeError = "======================================================" . PHP_EOL;
            $mensajeError .= "Excepción: " . $exception->getMessage() . PHP_EOL;
            $mensajeError .= "Archivo: " . $exception->getFile() . PHP_EOL;
            $mensajeError .= "Línea: " . $exception->getLine() . PHP_EOL;
            $mensajeError .= "Trace de la pila:" . PHP_EOL . $exception->getTraceAsString() . PHP_EOL;
            $mensajeError .= "Fecha y hora: " . date("Y-m-d H:i:s") . PHP_EOL;
            $mensajeError .= "======================================================" . PHP_EOL;

            // Registrar el error en un archivo
            error_log($mensajeError, 3, "php-error.log");
            // Redirigir al usuario a la página de error o mostrar un mensaje personalizado
            header("Location: ./src/config/error.html");
            exit();
        });
    }
    public function captureError()
    {
        error::configuracion();
    }
}

// Crear una instancia y configurar el manejador de errores


// Registrar un mensaje de error de ejemplo
