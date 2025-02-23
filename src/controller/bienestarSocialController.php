<?php

namespace App\Atlas\controller;

use App\Atlas\config\Conexion;
use App\Atlas\models\tablasModel;
use App\Atlas\models\bienestarSocialModel;

class bienestarSocialController extends bienestarSocialModel
{

    private $tablas;

    public function __construct()
    {
        parent::__construct();
        $this->tablas = new tablasModel();
    }

    public function datosBienestar()
    {
        $data_json['data'] = []; // Array de datos para enviar
        $tabla = 'datosempleados INNER JOIN datospersonales ON datosempleados.idPersonal = datospersonales.id_personal INNER JOIN cargo ON datosempleados.idCargo = cargo.id_cargo'; // Tabla a consultar
        $selectoresCantidad = 'COUNT(id_empleados) as cantidad'; // Selector para contar la cantidad de registros de la tabla
        $datosBuscar = []; // Array de selectores para buscar en la tabla
        $campoOrden = 'id_empleados'; // Campo por el cual se ordenará la tabla
        $selectores = '*'; // Selectores para obtener los datos de la tabla
        $conditions = []; // Condiciones para obtener los datos de la tabla
        $conditionParams = []; // Parámetros de las condiciones

        $draw = $_REQUEST['draw'];
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $searchValue = $_REQUEST['search']['value'];

        // Obtener la cantidad de los datos de la tabla
        $cantidadRegistro = $this->tablas->getCantidadRegistros($tabla, $selectoresCantidad, $conditions, $conditionParams);
        // Obtener los datos de la tabla
        $personal = $this->tablas->getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden, $conditions, $conditionParams, $ordenTabla = 'ASC');
        // Recorrer datos de la tabla

        foreach ($personal as $row) {
            $cedula = $row['cedula'];
            $nombre = $row['primerNombre']; // Suponiendo que el nombre del personal está en el campo 'primerNombre'
            $apellido = $row['primerApellido']; // Suponiendo que el apellido del personal está en el campo 'primerApellido'
            // Buscar la imagen PNG por medio de la cédula
            $imagenPath = "./src/global/archives/photos/{$cedula}.png"; // Ajusta la ruta según sea necesario

            $imagen = "
                <div class='d-flex align-items-center text-center'>
                <img src='{$imagenPath}' class='img-table' alt='Imagen de {$nombre}'>
                <p class ='m-0'>{$nombre} {$apellido}</p>
                </div>";

        $botones = "

        <button class='btn btn-danger btnDescargarFicha btn-sm btn-hover-rojo' data-id=" . $row['cedula'] .  "><i class='fa-solid fa-inbox-in me-2'></i>Solicitar Ficha</button>
        ";


            $data_json['data'][] = [
                '0' => $imagen,
                '1' => $row['correo'],
                '2' => $row['cargo'],
                '3' => $row['telefono'],
                '4' =>$botones

            ];
            $data_json['mensaje'] = "todas las dependencias de manera exitosa";
        }

        // Devolver la respuesta a DataTables
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $cantidadRegistro[0]['cantidad'],
            "recordsFiltered" => $cantidadRegistro[0]['cantidad'],
            "data" => $data_json['data']
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    

    public function datosRnuncia()
    {
        $data_json['data'] = []; // Array de datos para enviar
        $tabla = 'datosempleados INNER JOIN datospersonales ON datosempleados.idPersonal = datospersonales.id_personal INNER JOIN cargo ON datosempleados.idCargo = cargo.id_cargo'; // Tabla a consultar
        $selectoresCantidad = 'COUNT(id_empleados) as cantidad'; // Selector para contar la cantidad de registros de la tabla
        $datosBuscar = []; // Array de selectores para buscar en la tabla
        $campoOrden = 'id_empleados'; // Campo por el cual se ordenará la tabla
        $selectores = '*'; // Selectores para obtener los datos de la tabla
        $conditions = []; // Condiciones para obtener los datos de la tabla
        $conditionParams = []; // Parámetros de las condiciones

        $draw = $_REQUEST['draw'];
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $searchValue = $_REQUEST['search']['value'];

        // Obtener la cantidad de los datos de la tabla
        $cantidadRegistro = $this->tablas->getCantidadRegistros($tabla, $selectoresCantidad, $conditions, $conditionParams);
        // Obtener los datos de la tabla
        $personal = $this->tablas->getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden, $conditions, $conditionParams, $ordenTabla = 'ASC');
        // Recorrer datos de la tabla

        foreach ($personal as $row) {
            $cedula = $row['cedula'];
            $nombre = $row['primerNombre']; // Suponiendo que el nombre del personal está en el campo 'primerNombre'
            $apellido = $row['primerApellido']; // Suponiendo que el apellido del personal está en el campo 'primerApellido'
            // Buscar la imagen PNG por medio de la cédula
            $imagenPath = "./src/global/archives/photos/{$cedula}.png"; // Ajusta la ruta según sea necesario

            $imagen = "
                <div class='d-flex align-items-center text-center'>
                <img src='{$imagenPath}' class='img-table' alt='Imagen de {$nombre}'>
                <p class ='m-0'>{$nombre} {$apellido}</p>
                </div>";

        $botones = "

        <button class='btn btn-danger btnDescargarFicha btn-sm btn-hover-rojo' data-id=" . $row['cedula'] .  "><i class='fa-solid fa-inbox-in me-2'></i>Solicitar Ficha</button>
        ";


            $data_json['data'][] = [
                '0' => $imagen,
                '1' => $row['correo'],
                '2' => $row['cargo'],
                '3' => $row['telefono'],
                '4' =>$botones

            ];
            $data_json['mensaje'] = "todas las dependencias de manera exitosa";
        }

        // Devolver la respuesta a DataTables
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $cantidadRegistro[0]['cantidad'],
            "recordsFiltered" => $cantidadRegistro[0]['cantidad'],
            "data" => $data_json['data']
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
