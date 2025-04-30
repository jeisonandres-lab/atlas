<?php
namespace App\Atlas\controller;
use App\Atlas\models\AuditoriaModel;

class AuditoriaController {

    private $auditoriaModel;
    private static $codigosGenerado; // Array para almacenar los códigos generados

    public function __construct() {
        $this->auditoriaModel = new AuditoriaModel();
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

        $registrarAuditoria = $this->auditoriaModel->getRegistrarAuditoria($tabla, $parametros);
        if ($registrarAuditoria) {
            return true;
        } else {
            return false;
        }
    }

    private  static function generarCodigo() {
        $numeroAleatorio = mt_rand(1, 999);
        $codigo = str_pad($numeroAleatorio, 3, '0', STR_PAD_LEFT);
        return "00000".$codigo;
    }

    private function obtenerSistemaOperativo($user_agent) {
        $sistemas_operativos = [
            'Windows 10' => 'Windows NT 10.0',
            'Windows 11' => 'Windows NT 11.0|Windows NT 6.4',
            'Windows 8.1' => 'Windows NT 6.3',
            'Windows 8' => 'Windows NT 6.2',
            'Windows 7' => 'Windows NT 6.1',
            'Windows' => 'Windows NT',
            'macOS' => 'Macintosh|Mac OS X',
            'Android' => 'Android',
            'iOS' => 'iPhone|iPad'
        ];

        foreach ($sistemas_operativos as $nombre => $patron) {
            if (preg_match("/$patron/", $user_agent)) {
                return $nombre;
            }
        }

        if (preg_match('/Linux/', $user_agent)) {
            return 'sistema Linux';
        }

        return 'Desconocido';
    }

    private function obtenerNavegador($user_agent) {
        $navegadores = [
            'Edge' => 'Edg\/([0-9]+)',
            'Chrome' => 'Chrome\/([0-9]+)',
            'Firefox' => 'Firefox\/([0-9]+)',
            'Safari' => 'Safari\/([0-9]+)',
            'Opera' => 'Opera\/([0-9]+)',
            'Opera GX' => 'OPR\/([0-9]+)',
            'Vivaldi' => 'Vivaldi\/([0-9]+)'
        ];

        foreach ($navegadores as $nombre => $patron) {
            if (preg_match("/$patron/", $user_agent, $coincidencias)) {
                return $nombre;
            }
        }

        return 'Desconocido';
    }

    private function obtenerArquitectura($user_agent, $sistema_operativo) {
        if ($sistema_operativo === 'Android' || $sistema_operativo === 'iOS') {
            return 'ARM';
        }

        if (preg_match('/x86_64|Win64|WOW64|arm64|aarch64/', $user_agent)) {
            return '64-bit';
        } elseif (preg_match('/i386|i686|Win32|arm/', $user_agent)) {
            return '32-bit';
        } else {
            return 'Desconocida';
        }
    }

    private function analizarUserAgent($user_agent) {
        $datos = array();

        $datos['sistema_operativo'] = $this->obtenerSistemaOperativo($user_agent);
        $datos['navegador'] = $this->obtenerNavegador($user_agent);
        $datos['arquitectura'] = $this->obtenerArquitectura($user_agent, $datos['sistema_operativo']);
        $datos['ip'] = $_SERVER['REMOTE_ADDR'];

        return $datos;
    }
}