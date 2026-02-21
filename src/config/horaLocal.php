<?php
namespace App\Atlas\config;

class HoraLocal {
    private $timezone;

    public function __construct($timezone = "America/Caracas") {
        $this->timezone = $timezone;
        date_default_timezone_set($this->timezone);
    }

    public function obtenerFechaHoraServidor() {
        return date('c');
    }

    public function obtenerTimestamp() {
        return time();
    }

    public function obtenerFechaFormateada() {
        return date('d-m-Y H:i:s');
    }

    public function obtenerFechaFormateadaIngles() {
        return date('Y-m-d');
    }

    public function obtenerFechaFormateadaEsp() {
        return date('d-m-Y');
    }

    public function obtenerHoraFormateada() {
        return date('H:i:s');
    }

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
