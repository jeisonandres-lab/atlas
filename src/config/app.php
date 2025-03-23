<?php

namespace App\Atlas\config;


class App
{
    // Rutas De Archivos
    public const APP_URL = "http://localhost/atlas/";
    public const URL_NODE = "./node_modules/";
    public const URL_INC = "./src/views/inc/";
    public const URL_SCRIPS = "./src/assets/js/";
    public const URL_LIBRARY = "./src/libs/";
    public const URL_CSS = "./src/assets/css/";
    public const URL_IMG = "./src/assets/img/images/";
    public const URL_ICONS = "./src/assets/img/icons/";
    public const URL_FOTOS = "./src/global/photos/";
    public const APP_NAME = "ATLAS";

    // Rutas De Carpetas Y Archivos De Personal
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

    public static function zonaHoraria()
    {
        date_default_timezone_set("America/Caracas");
    }

    public function analizarURL($url)
    {
        $partes = explode('?', $url);
        $vista = explode('/', $partes[0])[2]; // Obtener la vista (tercera parte)
        $parametros = [];
        if (isset($partes[1])) {
            parse_str($partes[1], $parametros);
        }
        return ['vista' => $vista, 'parametros' => $parametros];
    }

    // public function analizarURL($url)
    // {
    //     $partes = explode('?', $url);
    //     $segmentos = explode('/', $partes[0]);
    //     $rol = '';
    //     $vista = '';

    //     Determinar si hay un rol y la vista
    //     if (count($segmentos) >= 4) { // Asegurarse de que hay al menos 4 segmentos (incluyendo 'localhost', 'atlas', 'rol' y 'vista')
    //         $rol = $segmentos[2];
    //         $vista = $segmentos[3];
    //     } elseif (count($segmentos) >= 3) { // Si no hay rol, pero hay una vista
    //         $vista = $segmentos[2];
    //     }

    //     $parametros = [];
    //     if (isset($partes[1])) {
    //         parse_str($partes[1], $parametros);
    //     }

    //     return ['rol' => $rol, 'vista' => $vista, 'parametros' => $parametros];
    // }

    public function iniciarSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function iniciarName()
    {
        return session_name(App::APP_NAME);
    }

    public function cerrarSession()
    {
        session_start();
        return session_destroy();
    }
}
