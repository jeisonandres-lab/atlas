<?php

namespace App\Atlas\models\public;

use App\Atlas\models\private\DependenciasModel;

class DependenciasModelPublic extends DependenciasModel
{

    public function __construct(){
        parent::__construct();
    }

    // Getters Para Accder a los Metodos de la Clase
    public function getDatosDependencia()
    {
        return $this->datosDependencia();
    }

    public function getActulizarDependencia($tabla, $datos, $condicion)
    {
        return $this->actulizarDependencia($tabla, $datos, $condicion);
    }

    public function getobtenerDependencia(array $parametro)
    {
        return $this->obtenerdependencia($parametro);
    }

    public function getVerificarCodigo($tabla, $codigo)
    {
        return $this->verificarCodigo($tabla, $codigo);
    }

    public function getVerificarDependencia($parametro)
    {
        return $this->verificarDependencia($parametro);
    }

    // public function getObtenerEstados()
    // {
    //     return $this->obtenerEstados();
    // }

    public function getRegistrar2($tabla, $datos)
    {
        return $this->registrarPersonal2($tabla, $datos);
    }



}