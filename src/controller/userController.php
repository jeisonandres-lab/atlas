<?php

namespace App\Atlas\controller;

use App\Atlas\config\Conexion;

class userController extends Conexion
{

    const APP_URL = "http://localhost/atlas/";
    public function hola(){
        echo 'hola';
    }
}
