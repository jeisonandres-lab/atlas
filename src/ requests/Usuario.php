<?php

namespace App\Atlas\requests;

require_once '../../vendor/autoload.php';

use App\Atlas\config\Conexion;
use App\Atlas\controller\UsuarioController;
use App\Atlas\controller\NotificacionController;

$conexion = new Conexion();
$usercontroller = new UsuarioController();
$userLogin = new UsuarioController();
$notificacion = new NotificacionController();
$id = isset($_POST['id']) ? $conexion->limpiarCadena($_POST['id']) : "";
$cedula = isset($_POST['cedula']) ? $conexion->limpiarCadena($_POST['cedula']) : "";
$pin = isset($_POST['pin']) ? $conexion->limpiarCadena($_POST['pin']) : "";
switch ($_GET['modulo_usuario']) {
    case 'login':
        $user = $conexion->limpiarCadena($_POST['usuario']);
        $password = $conexion->limpiarCadena($_POST['password']);
        $userLogin->logearse($user, $password);
        break;

    case 'redireccionar':
        $url = $_POST['url'];
        echo $userLogin->redireccionarUsuario($url);
        break;

    case 'cerrarSession':
        $url = $_POST['url'];
        echo $userLogin->cerrarSession_total($url);
        break;
    case 'datosUsuariosBasicos':
        $usercontroller->datosUsuariosBasicos();
        break;

    case 'DatosUsuarios':
        $usercontroller->datosUsuarios();
        break;

    case 'desactivarUsuario':
        $usercontroller->desactivarUsuario($id);
        break;

    case 'actualizarDatosUsuario':
        $usercontroller->desactivarUsuario($id);
        break;

    default:
        # code...
        break;
}
