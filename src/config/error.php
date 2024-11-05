<?php

namespace App\Atlas\config;
use App\Atlas\config\App;

class Error extends App
{
    private $errorReportingLevel = -1;
    private $ignoreRepeatedErrors = TRUE;
    private $displayErrors = FALSE;
    private $logErrors = TRUE;
    private $errorLogFile = "./src/error/php-error.log";

    public function __construct() {}

    private function registrarError($tipoError, $mensaje, $archivo, $linea)
    {
        $mensajeError = "======================================================" . PHP_EOL;
        $mensajeError .= "$tipoError: $mensaje" . PHP_EOL;
        $mensajeError .= "Archivo: $archivo" . PHP_EOL;
        $mensajeError .= "Línea: $linea" . PHP_EOL;
        $mensajeError .= "Fecha y hora: " . date("Y-m-d H:i:s") . PHP_EOL;
        $mensajeError .= "======================================================" . PHP_EOL;
        error_log($mensajeError, 3, "./src/error/php-error.log");
        // Aquí puedes agregar más acciones, como enviar un correo, notificar por Slack, etc.
    }

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
        // Manejador de excepciones
        set_exception_handler(function ($exception) {
            error::registrarError('Excepción', $exception->getMessage(), $exception->getFile(), $exception->getLine());

            exit();
        });

        // Manejador de errores
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            error::registrarError('Error', $errstr, $errfile, $errline);

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
