<?php

namespace App\Atlas\controller;

use App\Atlas\config\Conexion;
use App\Atlas\models\tablasModel;
use App\Atlas\models\vacacionesModel;
use App\Atlas\controller\AuditoriaController;

class vacacionesController extends vacacionesModel
{

    private $tablas;
    private $auditoriaController;

    public function __construct()
    {
        parent::__construct();
        $this->tablas = new tablasModel();
        $this->auditoriaController = new AuditoriaController();
    }

    public function registrarAusencia(string $cedula, string $id, $fecha_ini, $fecha_fin)
    {
        $cedula = $this->limpiarCadena($cedula);
        $id = $this->limpiarCadena($id);
        $fecha = date("Y-m-d");
        $fecha_ini = $this->limpiarCadena($fecha_ini);
        $fecha_fin = $this->limpiarCadena($fecha_fin);
        $data_json = [
            "exito" => false,
            "messenger" => "datos"
        ];

        $parametros = [$id, $fecha_ini, $fecha_fin];
        $parametroEstadoAusencia = [$id, 1];

        $validarEstadoAusencia = $this->getEstadoAusencia($parametroEstadoAusencia);
        if ($validarEstadoAusencia) {
            $data_json["exito"] = false;
            $data_json['messenger'] = "El estado de este empleado esta activo en el ausento.";
        } else {
            $ausenciaExiste = $this->getexisAusencia($parametros);
            if ($ausenciaExiste['existe']) {
                $data_json["exito"] = false;
                $data_json['messenger'] = "El empleado" . " " . $cedula . " ya tiene asignada una ausencia en las fechas proporcionadas.";
            }else{
                $parametrosRegistro = [
                    [
                        "campo_nombre" => "idEmpleado",
                        "campo_marcador" => ":idEmpleado",
                        "campo_valor" => $id
                    ],
                    [
                        "campo_nombre" => "fechaInicio",
                        "campo_marcador" => ":fechaInicio",
                        "campo_valor" => $fecha_ini
                    ],
                    [
                        "campo_nombre" => "fechaFinal",
                        "campo_marcador" => ":fechaFinal",
                        "campo_valor" => $fecha_fin
                    ],
                    [
                        "campo_nombre" => "idPermiso",
                        "campo_marcador" => ":idPermiso",
                        "campo_valor" => 2
                    ],
                    [
                        "campo_nombre" => "activo",
                        "campo_marcador" => ":activo",
                        "campo_valor" => "1"
                    ],
                    [
                        "campo_nombre" => "fecha",
                        "campo_marcador" => ":fecha",
                        "campo_valor" => date("Y-m-d")
                    ],
                    [
                        "campo_nombre" => "hora",
                        "campo_marcador" => ":hora",
                        "campo_valor" => date("H:i:s")
                    ]
                ];

                $registroAuditoria = $this->auditoriaController->registrarAuditoria($id, 'Registrar Ausencia', 'Se registro una ausencia justificada para el empleado con cedula' . " " . $cedula);
                if ($registroAuditoria) {
                    $data_json["exitoAuditoria"] = true;
                    $data_json['messengerAuditoria'] = "Auditoria registrada con exito.";
                } else {
                    $data_json["exito"] = false;
                    $data_json['messenger'] = "Error al registrar la auditoria.";
                }

                $registroAusencia = $this->getRegistrarAusencia('ausenciajustificada', $parametrosRegistro);
                if ($registroAusencia) {
                    $data_json["exito"] = true;
                    $data_json['messenger'] = "Ausencia registrada con exito.";
                } else {
                    $data_json["exito"] = false;
                    $data_json['messenger'] = "Error al registrar la ausencia.";
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }
}
