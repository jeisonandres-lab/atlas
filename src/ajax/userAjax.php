<?php

namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';

use App\Atlas\controller\userController;
use App\Atlas\controller\loginController;

$usercontroller = new userController();
$userLogin = new loginController();
switch (isset($_POST['modulo_usuario'])) {

    case 'login':
        $user = $userLogin->limpiarCadena($_POST['usuario']);
        $password = $userLogin->limpiarCadena($_POST['password']);
        $userLogin->logearse($user, $password);

    break;

    case 'inisioSesion':
        $data_json = [
            'exito' => false, // Inicializamos a false por defecto
            'mensaje' => 'si esto se resiviosssss'
        ];
        header('Content-Type: application/json');
        echo json_encode($data_json);
    break;

    default:
        # code...
        break;
}
