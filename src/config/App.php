<?php

namespace App\Atlas\config;


class App
{
    /**
     * Rutas de la aplicación
     */
    public const APP_URL = "http://localhost/atlas/";
    public const URL_NODE = "./node_modules/";
    public const URL_INC = "./src/views/inc/";
    public const URL_SCRIPS = "./src/assets/js/";
    public const URL_LIBRARY = "./src/libs/";
    public const URL_CSS = "./src/assets/css/";
    public const URL_IMG = "./src/assets/img/images/";
    public const URL_ICONS = "./src/assets/img/icons/";
    public const URL_FOTOS = "./src/global/photos/";

    /**
     * Nombre de la aplicación
     */
    public const APP_NAME = "ATLAS";

    /**
     * Ruta de errores
     */
    public const URL_ERROR = "./src/global/error/";

    /**
     * Rutas de carpetas y archivos de personal
     */
    public const URL_PARTIDANACIMIENTO = "../global/archives/archivoFamiliaresPersonal/partidasNacimiento/";
    public const URL_PARTIDADEISCAPACIDAD = "../global/archives/archivoFamiliaresPersonal/partidasDiscapacidad/";
    public const URL_CURRICULUMS = "../global/archives/curriculums/";
    public const URL_CONTRATOS = "../global/archives/archivoContratos/";
    public const URL_NOTACION = "../global/archives/archivoNotacion/";
    public const URL_MATRIMONIO = "../global/archives/archivoActaMatrimonio/";
    public const URL_DIRVORCIO = "../global/archives/archivoActaDivorcio/";
    public const URL_ESTADODEDERECHO = "../global/archives/archivoEstadoDeDerecho/";
    public const URL_DISCAPACIDADEMPELADO = "../global/archives/archivoActaDiscapacidad/";
    public const URL_VIUDO = "../global/archives/archivoActaDifucion/";
    public const URL_SOLICITUDCAMBIOESTADOCIVIL = "../global/archives/archivoSolicitudCambioEstadoCivil/";
    public const URL_COPIADECEDULACASADO = "../global/archives/archivoActaMatrimonio/copiaCedula";
    public const URL_COPIADECEDULACAMBIOESTADOCIVIL = "../global/archives/archivoSolicitudCambioEstadoCivil/copiaCedula";
    public const URL_COPIADECEDULAVIUDO = "../global/archives/archivoActaDifucion/copiaCedula";

    /**
     * Establece la zona horaria
     */
    public static function zonaHoraria()
    {
        date_default_timezone_set("America/Caracas");
    }

    /**
     * Analiza la URL
     * @param string $url
     * @return array
     */
    public function analizarURL($url): array
    {
        $partes = explode('?', $url);
        $vista = explode('/', $partes[0])[2]; // Obtener la vista (tercera parte)
        $parametros = [];
        if (isset($partes[1])) {
            parse_str($partes[1], $parametros);
        }
        return ['vista' => $vista, 'parametros' => $parametros];
    }

    /**
     * Imprime una respuesta JSON
     * @param array $respuesta
     * @return array
     */
    public function imprimirRespuestaJSON(array $respuesta): array
    {
        header('Content-Type: application/json');
        echo json_encode($respuesta);
        return $respuesta; // Devuelve el array después de imprimirlo
    }

    /**
     * Inicia una sesión
     */
    public function iniciarSession(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Inicia el nombre de la sesión
     * @return string
     */
    public function iniciarName(): string
    {
        return session_name(App::APP_NAME);
    }

    /**
     * Cierra una sesión
     * @return bool
     */
    public function cerrarSession(): bool
    {
        session_start();
        return session_destroy();
    }
}
