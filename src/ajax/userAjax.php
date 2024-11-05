<?php
require_once '../config/app.php';
use App\Atlas\controller\userController;

$user = new userController();

switch (isset($_POST['modulo_usuario'])) {
    case 'value':
        # code...
        break;

    default:
        # code...
        break;
}