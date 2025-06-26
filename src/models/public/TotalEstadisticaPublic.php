<?php
// filepath: c:\xampp\htdocs\atlas\src\models\public\TotalEstadisticaPublic.php

namespace App\Atlas\models\public;

use App\Atlas\models\private\TotalEstadisticaModel;

class TotalEstadisticaPublic extends TotalEstadisticaModel
{
    // No necesitas constructor si no agregas lógica extra
    public function __construct()
    {
        parent::__construct();
    }

    // FUNCION ME REGRESA LA CANTIDAD DE ARCHIVOS DEL MES
    public function getTotalArchivosMes()
    {
        return $this->totalArchivosMes();
    }

    // FUNCION ME REGRESA LA CANTIDAD DE ARCHIVOS DEL DIA
    public function getTotalArchivosDia()
    {
        return $this->totalArchivosDia();
    }

    // FUNCION ME REGRESA LA CANTIDAD DE EMPLEADOS REGISTRADOS
    public function getTotalEmpleados()
    {
        return $this->totalEmpleados();
    }

    // FUNCION ME REGRESA LA CANTIDAD DE ARCHIVOS REGISTRADOS Y SI SE PASA UN PARAMETRO DE FECHA
    // REGRESA LA CANTIDAD DE ARCHIVOS REGISTRADOS EN ESA FECHA
    public function getTotalArchivos($parametro)
    {
        return $this->totalArchivos($parametro);
    }

    // FUNCION ME REGRESA LA CANTIDAD DE PERMISOS 
    public function getTotalPermisos($parametro)
    {
        return $this->totalPermisos($parametro);
    }

    // FUNCION ME REGRESA EL PORCENTAJE DE ARCHIVOS SUBIDOS
    public function getPorcentajeTotalArchivos()
    {
        return $this->porcentajeTotalArchivos();
    }
}
