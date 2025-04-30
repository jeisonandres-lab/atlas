<?php
namespace App\Atlas\config;

class HoraLocal {
    private $timezone;

    /**
     * Constructor de la clase HoraLocal
     * @param string $timezone
     */
    public function __construct($timezone = "America/Caracas") {
        $this->timezone = $timezone;
        date_default_timezone_set($this->timezone);
    }

    /**
     * Obtiene la fecha y hora del servidor
     * @return string
     */
    public function obtenerFechaHoraServidor() {
        return date('c');
    }

    /**
     * Obtiene el timestamp
     * @return int
     */
    public function obtenerTimestamp() {
        return time();
    }

    /**
     * Obtiene la fecha y hora formateada
     * @return string
     */
    public function obtenerFechaFormateada() {
        return date('d-m-Y H:i:s');
    }

    /**
     * Obtiene la fecha y hora formateada en inglés
     * @return string
     */
    public function obtenerFechaFormateadaIngles() {
        return date('Y-m-d');
    }

    /**
     * Obtiene la fecha y hora formateada en español
     * @return string
     */
    public function obtenerFechaFormateadaEsp() {
        return date('d-m-Y');
    }

    /**
     * Obtiene la hora formateada
     * @return string
     */
    public function obtenerHoraFormateada() {
        return date('H:i:s');
    }

    /**
     * Obtiene los datos totales del servidor
     * @return array
     */
    public function obtenerDatosTotalServidor() {
        return [
            'fecha_hora_servidor' => $this->obtenerFechaHoraServidor(),
            'timestamp' => $this->obtenerTimestamp(),
            'fecha_formateada' => $this->obtenerFechaFormateada(),
            'hora_formateada' => $this->obtenerHoraFormateada(),
            'fecha_formateada_ingles' => $this->obtenerFechaFormateadaIngles(),
            'fecha_formateada_esp' => $this->obtenerFechaFormateadaEsp(),
        ];
    }
}



?>
