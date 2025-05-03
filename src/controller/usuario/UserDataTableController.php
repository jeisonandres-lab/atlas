<?php

namespace App\Atlas\controller\User;

use App\Atlas\models\TablasModel;

class UserDataTableController
{
    protected $tablas;

    public function __construct()
    {

        $this->tablas = new TablasModel();
    }

    /**
     * Obtiene los datos básicos de usuarios para DataTables
     */
    public function getBasicUserData()
    {
        $data_json['data'] = [];
        $tabla = 'users INNER JOIN rol ON users.idRol = rol.id_rol';
        $selectoresCantidad = 'COUNT(id_user) as cantidad';
        $datosBuscar = [];
        $campoOrden = 'id_user';
        $selectores = '*';
        $conditions = [];
        $conditionParams = [];

        $draw = $_REQUEST['draw'];
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $searchValue = $_REQUEST['search']['value'];

        $cantidadRegistro = $this->tablas->getCantidadRegistros(
            $tabla,
            $selectoresCantidad,
            $conditions,
            $conditionParams
        );

        $personal = $this->tablas->getTodoDatosPersonal(
            $selectores,
            $tabla,
            $start,
            $length,
            $searchValue,
            $datosBuscar,
            $campoOrden,
            $conditions,
            $conditionParams,
            'ASC'
        );

        foreach ($personal as $row) {
            $data_json['data'][] = [
                '0' => $row['enUso'],
                '1' => $row['nameUser'],
                '2' => $row['rol'],
                '3' => $row['activo'],
            ];
        }

        $response = [
            "draw" => intval($draw),
            "recordsTotal" => $cantidadRegistro[0]['cantidad'],
            "recordsFiltered" => $cantidadRegistro[0]['cantidad'],
            "data" => $data_json['data']
        ];

        $this->sendResponse($response);
    }

    /**
     * Obtiene los datos detallados de usuarios para DataTables
     */
    public function getDetailedUserData()
    {
        $data_json['data'] = [];
        $tabla = 'users us
            INNER JOIN datosempleados dp ON us.idEmpleado = dp.id_empleados
            INNER JOIN datospersonales dpe ON dp.idPersonal = dpe.id_personal
            INNER JOIN cargo ca ON dp.idCargo = ca.id_cargo
            INNER JOIN rol r ON us.idRol = r.id_rol';

        $selectoresCantidad = 'COUNT(id_cargo) as cantidad';
        $datosBuscar = ['nameUser'];
        $campoOrden = 'id_user';
        $selectores = '*, us.activo AS activoUser';
        $conditions = [];
        $conditionParams = [];

        $draw = $_REQUEST['draw'];
        $start = $_REQUEST['start'];
        $length = $_REQUEST['length'];
        $searchValue = $_REQUEST['search']['value'];

        $cantidadRegistro = $this->tablas->getCantidadRegistros(
            $tabla,
            $selectoresCantidad,
            $conditions,
            $conditionParams
        );

        $personal = $this->tablas->getTodoDatosPersonal(
            $selectores,
            $tabla,
            $start,
            $length,
            $searchValue,
            $datosBuscar,
            $campoOrden,
            $conditions,
            $conditionParams,
            'DESC'
        );

        foreach ($personal as $row) {
            $enUso = $row['enUso'] == 0 ? 'No' : 'Si';
            $buttons = $this->generateActionButtons($row);

            $data_json['data'][] = [
                '0' => $row['activoUser'],
                '1' => $row['cedula'],
                '2' => $row['nameUser'],
                '3' => $row['rol'],
                '4' => $enUso,
                '5' => $buttons,
            ];
        }

        $response = [
            "draw" => intval($draw),
            "recordsTotal" => $cantidadRegistro[0]['cantidad'],
            "recordsFiltered" => $cantidadRegistro[0]['cantidad'],
            "data" => $data_json['data']
        ];

        $this->sendResponse($response);
    }

    private function generateActionButtons($row): string
    {
        $buttons = "";

        if ($row['activo'] == 0) {
            $buttons .= "
                <button class='btn btn-success btn-sm btn-hover-verde btnActivarCargo'
                        data-id='{$row['id_user']}'>
                    <i class='fa-solid fa-check fa-sm me-2'></i>Activar
                </button>";
        } else {
            $buttons .= "
                <button class='btn btn-danger btn-sm btn-hover-rojo btnEliminarUsuario'
                        data-swal-toast-template='#my-template'
                        data-id='{$row['id_user']}'>
                    <i class='fa-solid fa-trash fa-sm me-2'></i>Desactivar
                </button>";
        }

        return $buttons;
    }

    private function sendResponse($data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}