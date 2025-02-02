<?php

namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';

use App\Atlas\controller\userController;
use App\Atlas\controller\loginController;

$usercontroller = new userController();
$userLogin = new userController();


switch ($_GET['modulo_usuario']) {
    case 'login':
        $user = $userLogin->limpiarCadena($_POST['usuario']);
        $password = $userLogin->limpiarCadena($_POST['password']);
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
    case 'DatosUsuariosBasicos':
        $usercontroller->DatosUsuariosBasicos();
        break;

    default:
        # code...
        break;
}
