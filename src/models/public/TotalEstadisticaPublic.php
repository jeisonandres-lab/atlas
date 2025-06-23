<?php

namespace App\Atlas\models\public;

use App\Atlas\models\private\TotalEstadisticaModel;

class TotalEstadisticaPublic extends TotalEstadisticaModel
{
    var $totalDate; // Instancia de TotalEstadistica

    public function __construct()
    {
        parent::__construct();
        $this->totalDate = new TotalEstadisticaModel();
    }

    // FUNCION ME REGRESA LA CANTIDAD DE ARCHIVOS DEL MES
    public function getTotalArchivosMes()
    {
        return $this->totalDate->totalArchivosMes();
    }

    // FUNCION ME REGRESA LA LA CANTIDAD DE ARCHIVOS DEL DIA
    public function getTotalArchivosDia()
    {
        return $this->totalDate->totalArchivosDia();
    }

    // FUNCION ME REGRESA LA CANTIDAD DE EMPLEADOS REGISTRADOS
    public function getTotalEmpleados()
    {
        return $this->totalDate->totalEmpleados();
    }

    // FUNCION ME REGRESA LA CANTIDAD DE ARCHIVOS REGISTRADOS Y SI SE PASA UN PARAMETRO DE FECHA
    // REGRESA LA CANTIDAD DE ARCHIVOS REGISTRADOS EN ESA FECHA
    public function getTotalArchivos($parametro)
    {
        return $this->totalDate->totalArchivos($parametro);
    }

    // FUNCION ME REGRESA LA CANTIDAD DE PERMISOS 
    public function getTotalPermisos($parametro)
    {
        return $this->totalDate->totalPermisos($parametro);
    }

    // FUNCION ME REGRESA EL PORCENTAJE DE ARCHIVOS SUBIDOS
    public function getPorcentajeTotalArchivos()
    {
        return $this->totalDate->porcentajeTotalArchivos();
    }
    
} 