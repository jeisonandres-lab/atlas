<?php

namespace App\Atlas\controller\auditoria;

class UtilidadesAuditoria
{
    protected static function generarCodigo() {
        $numeroAleatorio = mt_rand(1, 999);
        $codigo = str_pad($numeroAleatorio, 3, '0', STR_PAD_LEFT);
        return "00000".$codigo;
    }

    protected function obtenerSistemaOperativo($user_agent) {
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

    protected function obtenerNavegador($user_agent) {
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

    protected function obtenerArquitectura($user_agent, $sistema_operativo) {
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

    protected function analizarUserAgent($user_agent) {
        $datos = array();

        $datos['sistema_operativo'] = $this->obtenerSistemaOperativo($user_agent);
        $datos['navegador'] = $this->obtenerNavegador($user_agent);
        $datos['arquitectura'] = $this->obtenerArquitectura($user_agent, $datos['sistema_operativo']);
        $datos['ip'] = $_SERVER['REMOTE_ADDR'];

        return $datos;
    }
}