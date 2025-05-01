<?php

namespace App\Atlas\routers;

require_once '../../vendor/autoload.php';

use App\Atlas\config\EjecutarSQL;
use App\Atlas\controller\usuario\LoginController;
use App\Atlas\controller\sistema\NotificacionController;

$ejecutarSQL = new EjecutarSQL();
// $usercontroller = new UsuarioController();
$userLogin = new LoginController();
$notificacion = new NotificacionController();

$id = isset($_POST['id']) ? $ejecutarSQL->limpiarCadena($_POST['id']) : "";
$cedula = isset($_POST['cedula']) ? $ejecutarSQL->limpiarCadena($_POST['cedula']) : "";
$pin = isset($_POST['pin']) ? $ejecutarSQL->limpiarCadena($_POST['pin']) : "";

switch ($_GET['modulo_usuario']) {
    case 'login':
        $user = $ejecutarSQL->limpiarCadena($_POST['usuario']);
        $password = $ejecutarSQL->limpiarCadena($_POST['password']);
        $userLogin->logearse($user, $password);
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
