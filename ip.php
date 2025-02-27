<?php

function obtenerSistemaOperativo($user_agent) {
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

function obtenerNavegador($user_agent) {
    $navegadores = [
        'Chrome' => 'Chrome\/([0-9]+)',
        'Firefox' => 'Firefox\/([0-9]+)',
        'Safari' => 'Safari\/([0-9]+)',
        'Edge' => 'Edg\/([0-9]+)',
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

function obtenerArquitectura($user_agent, $sistema_operativo) {
    if ($sistema_operativo === 'Android') {
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

function analizarUserAgent($user_agent) {
    $datos = array();

    $datos['sistema_operativo'] = obtenerSistemaOperativo($user_agent);
    $datos['navegador'] = obtenerNavegador($user_agent);
    $datos['arquitectura'] = obtenerArquitectura($user_agent, $datos['sistema_operativo']);
    $datos['ip'] = $_SERVER['REMOTE_ADDR'];

    return $datos;
}

// // Ejemplo de uso:
// $user_agent = $_SERVER['HTTP_USER_AGENT']; // Obtiene la cadena User Agent del usuario
// echo $user_agent;
// $datos_navegador = analizarUserAgent($user_agent);

// echo "IP del Usuario: " . $datos_navegador['ip'] . "<br>";
// echo "Sistema Operativo: " . $datos_navegador['sistema_operativo'] . "<br>";
// echo "Navegador: " . $datos_navegador['navegador'] . "<br>";
// echo "Arquitectura: " . $datos_navegador['arquitectura'] . "<br>";

// // Guardar la información en el archivo data.txt
// $archivo = "data.txt"; // Nombre del archivo donde se almacenará la información
// $d_ip = "Direccion IP: " . $datos_navegador['ip'] . "\n"; // String con la dirección IP incluida
// $fecha = "Fecha: " . date('D d S M,Y h:i a') . "\n"; // String con la fecha y hora
// $sistema_operativo = "Sistema Operativo: " . $datos_navegador['sistema_operativo'] . "\n"; // Sistema operativo
// $navegador = "Navegador: " . $datos_navegador['navegador'] . "\n"; // Navegador
// $arquitectura = "Arquitectura: " . $datos_navegador['arquitectura'] . "\n"; // Arquitectura

// $texto = $d_ip . $fecha . $sistema_operativo . $navegador . $arquitectura . "\n"; // String que se escribirá en el archivo

// $fh = fopen($archivo, 'a'); // Se abre el archivo con el nombre "data.txt"
// fwrite($fh, $texto); // Se guarda el contenido de la variable "texto" en el archivo
// fclose($fh); // Se cierra el archivo
$diadisfrute = '';
$dias = '2';
$diasDescuento =  $dias - $diadisfrute;

echo $diasDescuento;

?>


require "src/fpdf/fpdf.pdf";

$PDF = new FPDF();

$PDF->AddPage();
<!-- SUB MENU DEL MODULO -->

