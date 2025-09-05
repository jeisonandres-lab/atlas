<?php

namespace App\Atlas\models\public;

use App\Atlas\models\private\UsuarioModel;

class UsuarioModelPublic extends UsuarioModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getExisteUsuario($user)
    {
        return $this->existeUsuario($user);
    }

    public function getDatosUsuario($user)
    {
        return $this->datosUsuario($user);
    }

    public function getActualizarDatos($tabla, $datos, $condicion)
    {
        return $this->actulizarDato($tabla, $datos, $condicion);
    }

    // valdiar el pin de seguridad del usuario
    public function getPinSeguridad(array $parametros)
    {
        return $this->pinSeguridad($parametros);
    }
}