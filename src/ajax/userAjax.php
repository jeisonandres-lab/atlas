<?php

namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';

use App\Atlas\controller\userController;

$user = new userController();
switch (isset($_POST['modulo_usuario'])) {

    case 'login':
        $user->hola();
        break;

    default:
        # code...
        break;
}
