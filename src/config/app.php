<?php

namespace App\Atlas\config;

class App
{
    public const APP_URL = "http://localhost/atlas/";
    public const APP_NAME = "ATLAS";
    public const APP_SESSION_NAME = "atlas";

    public static function zonaHoraria()
    {
        session_name(App::APP_SESSION_NAME);
        date_default_timezone_set("America/Caracas");
    }
}





/*----------  Zona horaria  ----------*/
