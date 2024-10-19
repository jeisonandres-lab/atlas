<?php

namespace App\Atlas\config;

class error
{
    public $errorReportingLevel = E_ALL;
    public $ignoreRepeatedErrors = TRUE;
    public $displayErrors = FALSE;
    public $logErrors = TRUE;
    public $errorLogFile = "./php-error.log";

    public function __construct() {}

    public function configuracion()
    {
        error_reporting($this->errorReportingLevel); // Informe de errores: informe todos los errores excepto los avisos
        ini_set('ignore_repeated_errors', $this->ignoreRepeatedErrors); // Ignorar errores repetidos: siempre use TRUE
        ini_set('display_errors', $this->displayErrors); // Mostrar errores: use FALSE solo en entornos de producción o servidores reales. Use TRUE en entornos de desarrollo
        ini_set('log_errors', $this->logErrors); // Registrar errores en archivo: activar el registro de errores en un archivo
        ini_set("error_log", $this->errorLogFile); // Ruta del archivo de registro de errores: especificar la ruta del archivo donde se registrarán los errores
        error_log("Hello, errors!"); // Registrar mensaje de error: registrar un mensaje de error personalizado
    }
}

// Crear una instancia y configurar el manejador de errores


// Registrar un mensaje de error de ejemplo
