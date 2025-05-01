<?php

namespace App\Atlas\controller\Base;

use App\Atlas\config\App;
use App\Atlas\models\TablasModel;

abstract class BaseController
{
    protected $app;
    protected $tablas;

    public function __construct()
    {
        $this->app = new App();
        $this->tablas = new TablasModel();
    }

    /**
     * Verifica el formato de los datos según una expresión regular
     * @param string $pattern
     * @param string $value
     * @return bool
     */
    protected function verificarDatos(string $pattern, string $value): bool
    {
        return !preg_match("/$pattern/", $value);
    }
}