<?php

namespace App\Atlas\controller\unidadOrganizacional;

use App\Atlas\models\public\DepartamentoModelPublic;
use App\Atlas\models\public\CRUDModelPublic;
use App\Atlas\models\private\TablasModel;
use App\Atlas\controller\auditoria\AuditoriaController;
use App\Atlas\config\App;

class DepartamentoController
{
    private $tablas;
    private $auditoriaController;
    private $app;
    private $departamento;
    private $crud;

    private $idUsuario;
    private $nombreUsuario;

    public function __construct()
    {

        $this->tablas = new TablasModel();
        $this->app = new App();
        $this->auditoriaController = new AuditoriaController();
        $this->departamento = new DepartamentoModelPublic();
        $this->crud = new CRUDModelPublic();
        $this->app->iniciarSession();
        $this->idUsuario = $_SESSION['id'];
        $this->nombreUsuario = $_SESSION['usuario'];
    }

    //Obtener todos los departamentos
    public function obtenerDeparmatentoGeneral(){

        $data_json = [
            "exito" => false,
            "mensaje" => ""
        ];

        $datosGeneralDepartamento = $this->departamento->getObtenerDepartamentoGeneral();
        if (!empty($datosGeneralDepartamento)) {
            foreach($datosGeneralDepartamento as $row){
                $data_json["exito"] = true;
                $data_json['data'][] = [
                    'id' => $row['id_departamento'],
                    'value' => $row['departamento']
                ];
            }
        }else{

            $data_json["exito"] = false;
            $data_json["mensaje"] = "no se lograron obtener los departamento";
        }

         // Devolver la respuesta en formato JSON
         header('Content-Type: application/json');
         echo json_encode($data_json);
    }

    //Registrar departamento
    public function regisDepartamento(string $nombreDepartamento)
    {

        $datos_json = [
            'messenger' => '',
            'exito' => false
        ];

        $parametros = [
            [
                "campo_nombre" => "departamento",
                "campo_marcador" => ":departamento",
                "campo_valor" => $nombreDepartamento
            ],
            [
                "campo_nombre" => "activo",
                "campo_marcador" => ":activo",
                "campo_valor" => 1
            ],
        ];

        $validar = $this->departamento->getValidarDepartamento('departamento',  $nombreDepartamento);
        if (empty($validar)) {
            $registro =  $this->crud->getRegistrar('departamento', $parametros);
            if ($registro) {
                $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Registrar departamento', 'El usuario ' . $this->nombreUsuario . ' ha registrado el departamento ' . $nombreDepartamento . ' en el sistema.');
                if ($registroAuditoria) {
                    $datos_json["exitoAuditoria"] = true;
                    $datos_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                } else {
                    $datos_json["exitoAuditoria"] = false;
                    $datos_json['messengerAuditoria'] = "Error al registrar la auditoria.";
                }
                $datos_json['messenger'] = "Registro de departamento exitoso";
                $datos_json['exito'] = true;
            } else {
                $datos_json['messenger'] = "Error al registrar";
            }
        } else {
            $data_json['messenger'] = "El Departamento ya se encuentra registrado";
        }


        header('Content-Type: application/json');
        echo json_encode($datos_json);
    }

    //Editar departamento
    public function editarDepartamento($id, $Departamento)
    {
        $data_json = [
            'messenger' => '',
            'exito' => false
        ];
        $parametros = [
            [
                "campo_nombre" => "departamento",
                "campo_marcador" => ":departamento",
                "campo_valor" => $Departamento
            ],

        ];

        $condicion = [
            "condicion_campo" => "id_departamento",
            "condicion_marcador" => ":id_departamento",
            "condicion_valor" => $id
        ];

        $buscarDepartamento = $this->departamento->getObtenerDatosDepartamento([$id]);
        if (empty($buscarDepartamento)) {
            $data_json['exito'] = false;
            $data_json['messenger'] = 'No se pudo obtener los datos del departamento';
        }else{
            foreach ($buscarDepartamento as $row) {
                $departamentoViejo = $row['departamento'];
                $validar = $this->departamento->getValidarDepartamento('departamento',  $Departamento);
                if (empty($validar)) {
                    $registro = $this->crud->getActualizar('departamento', $parametros,  $condicion);
                    if ($registro) {
                        $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Editar departamento', 'El usuario ' . $this->nombreUsuario . ' ha editado el departamento ' . $departamentoViejo . ' por ' . $Departamento . ' en el sistema.');
                        if ($registroAuditoria) {
                            $data_json["exitoAuditoria"] = true;
                            $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                        } else {
                            $data_json["exitoAuditoria"] = false;
                            $data_json['messengerAuditoria'] = "Error al registrar la auditoria.";
                        }
                        $data_json['messenger'] = "Departamento editado con éxito";
                        $data_json['exito'] = true;
                    } else {
                        $data_json['messenger'] = "Error al editar el cargo";
                    }
                } else {
                    $data_json['messenger'] = "El Departamento ya se encuentra registrado";
                }
            }
        }



        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    //Actualizar deaprtamento de activo a no activo
    public function eliminarActivarDepartamento(string $id, $activo)
    {
        $data_json = [
            'exito' => false,
            'messenger' => 'No se pudo obtener los datos de la dependencia',
        ];

        $activador = $activo;
        $estadoEli = ($activador == 1) ? "activado" : "desactivado";
        $estadoEli2 = ($activador == 1) ? "Activación" : "Desactivación";

        $parametros = [
            [
                "campo_nombre" => "activo",
                "campo_marcador" => ":activo",
                "campo_valor" =>  $activador
            ]
        ];

        $condicion = [
            "condicion_campo" => "id_departamento",
            "condicion_marcador" => ":id_departamento",
            "condicion_valor" => $id
        ];

        $buscarDepartamento = $this->departamento->getObtenerDatosDepartamento([$id]);
        if (empty($buscarDepartamento)) {
            $data_json['exito'] = false;
            $data_json['messenger'] = 'No se pudo obtener los datos del departamento';
        } else {
            foreach ($buscarDepartamento as $row) {
                $departamento = $row['departamento'];
                $actualizar = $this->crud->getActualizar('departamento', $parametros, $condicion);

                if ($actualizar) {
                    $data_json['exito'] = true;

                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, $estadoEli2 . ' departamento', 'El usuario ' . $this->nombreUsuario . ' ha ' . $estadoEli . ' el departamento ' . $departamento . ' en el sistema.');
                    if ($registroAuditoria) {
                        $data_json["exitoAuditoria"] = true;
                        $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                    } else {
                        $data_json["exitoAuditoria"] = false;
                        $data_json['messengerAuditoria'] = "Error al registrar la auditoria.";
                    }

                    if ($activador == 1) {
                        $data_json['messenger'] = 'Departamento activado con exito';
                    } else {
                        $data_json['messenger'] = 'Departamento desactivado con exito';
                    }
                }
            }
        }

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    //Obtener datos de departamento para DataTables js
    public function datosDepartamento()
    {
        $data_json['data'] = []; // Array de datos para enviar
        $tabla = 'departamento'; // Tabla a consultar
        $selectoresCantidad = 'COUNT(id_departamento) as cantidad'; // Selector para contar la cantidad de registros de la tabla
        $datosBuscar = ['departamento']; // Array de selectores para buscar en la tabla
        $campoOrden = 'id_departamento'; // Campo por el cual se ordenará la tabla
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
        $personal = $this->tablas->getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden, $conditions, $conditionParams, $ordenTabla = 'DESC');
        // Recorrer datos de la tabla

        foreach ($personal as $row) {
            $buttons = "
                <button class='btn btn-primary btn-sm btn-hover-azul btnEditarDepa' data-bs-toggle='modal' data-bs-target='#modalDepartamento' data-id='" . $row['id_departamento'] . "'><i class='fa-solid fa-pencil fa-sm me-2'></i>Editar</button>
               ";
            if ($row['activo'] == 0) {
                $buttons .= "
                <button class='btn btn-success btn-sm btn-hover-verde btnActivarDepa' data-id='" . $row['id_departamento'] . "'><i class='fa-solid fa-check fa-sm me-2'></i>Activar</button>
                ";
            } else {
                $buttons .= "
                <button class='btn btn-danger btn-sm btn-hover-rojo btnEliminarDepa' data-swal-toast-template='#my-template' data-id='" . $row['id_departamento'] . "'><i class='fa-solid fa-trash fa-sm me-2'></i>Eliminar</button>
                ";
            }
            $data_json['data'][] = [
                '0' => $row['departamento'],
                '1' => $row['activo'],
                '2' => $buttons,
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
