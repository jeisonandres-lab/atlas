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
    public const URL_FOTOS = "./src/assets/photos/";
    public const APP_NAME = "ATLAS";

    // Rutas De Carpetas Y Archivos De Personal
    public const URL_PARTIDANACIMIENTO = "../global/archives/personal/familiares/partidasNacimiento/";
    public const URL_PARTIDADEISCAPACIDAD = "../global/archives/personal/familiares/partidasDiscapacidad/";
    public const URL_CURRICULUMS = "../global/archives/curriculums/";
    public const URL_FOTOS_PERSONAL = "../global/archives/photos/";
    public const URL_CONTRATOS = "../global/archives/contratos/";
    public const URL_NOTACION = "../global/archives/notacion/";

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

    public function iniciarSession()
    {
       return session_start();

    }

    public function iniciarName()
    {
        return session_name(App::APP_NAME);
    }

    public function cerrarSession()
    {
        return session_destroy();
    }
}
