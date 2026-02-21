<?php
namespace App\Atlas\config;

use App\Atlas\config\Conexion;

class peticiones extends Conexion {
    public function __construct() {
        parent::__construct();
    }

    public function obtenerVariables() {
        return [
            'primerNombre' => isset($_POST['primerNombre']) ? $this->limpiarCadena($_POST['primerNombre']) : "",
            'segundoNombre' => isset($_POST['segundoNombre']) ? $this->limpiarCadena($_POST['segundoNombre']) : "",
            'primerApellido' => isset($_POST['primerApellido']) ? $this->limpiarCadena($_POST['primerApellido']) : "",
            'segundoApellido' => isset($_POST['segundoApellido']) ? $this->limpiarCadena($_POST['segundoApellido']) : "",
            'primerNombreFamiliar' => isset($_POST['primerNombreFamiliar']) ? $this->limpiarCadena($_POST['primerNombreFamiliar']) : "",
            'segundoNombreFamiliar' => isset($_POST['segundoNombreFamiliar']) ? $this->limpiarCadena($_POST['segundoNombreFamiliar']) : "",
            'primerApellidoFamiliar' => isset($_POST['primerApellidoFamiliar']) ? $this->limpiarCadena($_POST['primerApellidoFamiliar']) : "",
            'segundoApellidoFamiliar' => isset($_POST['segundoApellidoFamiliar']) ? $this->limpiarCadena($_POST['segundoApellidoFamiliar']) : "",
            'parentesco' => isset($_POST['parentesco']) ? $this->limpiarCadena($_POST['parentesco']) : "",
            'cedula' => isset($_POST['cedula']) ? $this->limpiarCadena($_POST['cedula']) : "",
            'cedulaFamiliar' => isset($_POST['cedulaFamiliar']) ? $this->limpiarCadena($_POST['cedulaFamiliar']) : "",
            'cedulaEmpleado' => isset($_POST['cedulaEmpleado']) ? $this->limpiarCadena($_POST['cedulaEmpleado']) : "",
            'civil' => isset($_POST['civil']) ? $this->limpiarCadena($_POST['civil']) : "",
            'correo' => isset($_POST['correo']) ? $this->limpiarCadena($_POST['correo']) : "",
            'ano' => isset($_POST['ano']) ? $this->limpiarCadena($_POST['ano']) : "",
            'mes' => isset($_POST['meses']) ? $_POST['meses'] : "",
            'dia' => isset($_POST['dia']) ? $this->limpiarCadena($_POST['dia']) : "",
            'edad' => isset($_POST['edad']) ? $this->limpiarCadena($_POST['edad']) : "",
            'sexo' => isset($_POST['sexo']) ? $this->limpiarCadena($_POST['sexo']) : "",
            'discapacidad' => isset($_POST['tpDiscapacidad']) ? $this->limpiarCadena($_POST['tpDiscapacidad']) : "",
            'nivelAcademico' => isset($_POST['nivelAcademico']) ? $this->limpiarCadena($_POST['nivelAcademico']) : "",
            'fechaING' => isset($_POST['fechaing']) ? $this->limpiarCadena($_POST['fechaing']) : "",
            'fecha_ini' => isset($_POST['fecha_ini_filtrar']) ? $this->limpiarCadena($_POST['fecha_ini_filtrar']) : "",
            'fecha_fin' => isset($_POST['fecha_fin_filtrar']) ? $this->limpiarCadena($_POST['fecha_fin_filtrar']) : "",
            'telefono' => isset($_POST['telefono']) ? $this->limpiarCadena($_POST['telefono']) : "",
            'linea' => isset($_POST['linea']) ? $this->limpiarCadena($_POST['linea']) : "",
            'numeroCarnet' => isset($_POST['carnet']) ? $this->limpiarCadena($_POST['carnet']) : "",
            'tomo' => isset($_POST['tomo']) ? $this->limpiarCadena($_POST['tomo']) : "",
            'familiarInces' => isset($_POST['familiarInces']) ? $this->limpiarCadena($_POST['familiarInces']) : "",
            'folio' => isset($_POST['folio']) ? $this->limpiarCadena($_POST['folio']) : "",
            'vivienda' => isset($_POST['vivienda']) ? $this->limpiarCadena($_POST['vivienda']) : "",
            'calle' => isset($_POST['calle']) ? $this->limpiarCadena($_POST['calle']) : "",
            'numeroVivienda' => isset($_POST['numeroVivienda']) ? $this->limpiarCadena($_POST['numeroVivienda']) : "",
            'pisoUrba' => isset($_POST['piso']) ? $this->limpiarCadena($_POST['piso']) : "",
            'nombreUrba' => isset($_POST['urbanizacion']) ? $this->limpiarCadena($_POST['urbanizacion']) : "",
            'numeroDepa' => isset($_POST['numeroDepa']) ? $this->limpiarCadena($_POST['numeroDepa']) : "",
            'idPersonal' => isset($_POST['id']) ? $this->limpiarCadena($_POST['id']) : "",
            'idPersonal2' => isset($_POST['idPersonal']) ? $this->limpiarCadena($_POST['idPersonal']) : "",
            'idfamiliar' => isset($_POST['idfamiliar']) ? $this->limpiarCadena($_POST['idfamiliar']) : "",
            'idEmpleado' => isset($_POST['idEmpleado']) ? $this->limpiarCadena($_POST['idEmpleado']) : "",
            'idestado' => isset($_POST['estado']) ? $this->limpiarCadena($_POST['estado']) : "",
            'idestado2' => isset($_POST['idestado']) ? $this->limpiarCadena($_POST['idestado']) : "",
            'idMunicipio' => isset($_POST['municipio']) ? $this->limpiarCadena($_POST['municipio']) : "",
            'idMunicipio2' => isset($_POST['idmunicipio']) ? $this->limpiarCadena($_POST['idmunicipio']) : "",
            'idParroquia' => isset($_POST['parroquia']) ? $this->limpiarCadena($_POST['parroquia']) : "",
            'idEstatus' => isset($_POST['estatus']) ? $this->limpiarCadena($_POST['estatus']) : "",
            'idCargo' => isset($_POST['cargo']) ? $this->limpiarCadena($_POST['cargo']) : "",
            'idDepartamento' => isset($_POST['departamento']) ? $this->limpiarCadena($_POST['departamento']) : "",
            'idDependencia' => isset($_POST['dependencia']) ? $this->limpiarCadena($_POST['dependencia']) : "",
        ];
    }

    public function convertirFecha($fecha) {
        $fechaObj = \DateTime::createFromFormat('d-m-Y', $fecha);
        return $fechaObj ? $fechaObj->format('Y-m-d') : false;
    }
}