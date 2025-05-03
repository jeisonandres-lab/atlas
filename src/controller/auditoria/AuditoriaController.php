<?php
namespace App\Atlas\controller\auditoria;

use App\Atlas\models\public\AuditoriaModelPublic;
use App\Atlas\controller\auditoria\UtilidadesAuditoria;

class AuditoriaController extends UtilidadesAuditoria {

    private $auditoriaModelPublic;

    public function __construct() {
        // Instancia del modelo de auditoría
        $this->auditoriaModelPublic = new AuditoriaModelPublic();
    }

    public function registrarAuditoria($idUsuario, $accion, $descripcion) {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $datos_navegador = $this->analizarUserAgent($user_agent);

        $ip = $datos_navegador['ip'];
        $sistema_operativo = $datos_navegador['sistema_operativo'];
        $navegador = $datos_navegador['navegador'];
        $arquitectura = $datos_navegador['arquitectura'];
        $codigoAuditoria = $this->generarCodigo(); // Generar el código de auditoría
        // Aquí puedes agregar la lógica para registrar la auditoría con los datos obtenidos
        $tabla = 'auditoria';
        $parametros = [
            [
                "campo_nombre" => "user_id",
                "campo_marcador" => ":user_id",
                "campo_valor" => $idUsuario
            ],
            [
                "campo_nombre" => "codigo",
                "campo_marcador" => ":codigo",
                "campo_valor" => $codigoAuditoria
            ],
            [
                "campo_nombre" => "tipo_evento",
                "campo_marcador" => ":tipo_evento",
                "campo_valor" => $accion
            ],
            [
                "campo_nombre" => "descripcion",
                "campo_marcador" => ":descripcion",
                "campo_valor" => $descripcion
            ],
            [
                "campo_nombre" => "ip",
                "campo_marcador" => ":ip",
                "campo_valor" => $ip
            ],
            [
                "campo_nombre" => "sistemaOperativo",
                "campo_marcador" => ":sistemaOperativo",
                "campo_valor" => $sistema_operativo
            ],
            [
                "campo_nombre" => "navegador",
                "campo_marcador" => ":navegador",
                "campo_valor" => $navegador
            ],
            [
                "campo_nombre" => "arquitectura",
                "campo_marcador" => ":arquitectura",
                "campo_valor" => $arquitectura
            ],
            [
                "campo_nombre" => "fecha",
                "campo_marcador" => ":fecha",
                "campo_valor" => date("Y-m-d")
            ],
            [
                "campo_nombre" => "hora",
                "campo_marcador" => ":hora",
                "campo_valor" => date("H:i:s A")
            ]

        ];

        $registrarAuditoria = $this->auditoriaModelPublic->getRegistrarAuditoria($tabla, $parametros);
        if ($registrarAuditoria) {
            return true;
        } else {
            return false;
        }
    }


}