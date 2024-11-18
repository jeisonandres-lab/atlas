<?php
namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';

use App\Atlas\controller\personalController;

$personal = new personalController();

$primerNombre = isset($_POST['primerNombre']);
$segundoNombre = isset($_POST['segundoNombre']);
$primerApellido = isset($_POST['primerApellido']);
$segundoApellido = isset($_POST['segundoApellido']);
$cedula = isset($_POST['cedula']);
$civil = isset($_POST['civil']);
$correo = isset($_POST['correo']);
$ano = isset($_POST['ano']);
$mes = isset($_POST['mes']);
$dia = isset($_POST['dia']);
switch ($_GET['modulo_personal']) {
    case 'registrar':
        $personal->registro($primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $cedula, $civil, $correo, $ano, $mes, $dia);

    break;

    default:
        # code...
        break;
}
