<?php
namespace App\Atlas\ajax;

require_once '../../vendor/autoload.php';
use App\Atlas\config\Conexion;
use App\Atlas\controller\personalController;

$personal = new personalController();
$conexion = new conexion();

$primerNombre = isset($_POST['primerNombre'])? $conexion->limpiarCadena($_POST['primerNombre']):"";
$segundoNombre = isset($_POST['segundoNombre'])? $conexion->limpiarCadena($_POST['segundoNombre']):"";
$primerApellido = isset($_POST['primerApellido'])? $conexion->limpiarCadena($_POST['primerApellido']):"";
$segundoApellido = isset($_POST['segundoApellido'])? $conexion->limpiarCadena($_POST['segundoApellido']):"";
$cedula = isset($_POST['cedula'])? $conexion->limpiarCadena($_POST['cedula']):"";
$civil = isset($_POST['civil'])? $conexion->limpiarCadena($_POST['civil']):"";
$correo = isset($_POST['correo'])? $conexion->limpiarCadena($_POST['correo']):"";
$ano = isset($_POST['ano'])? $conexion->limpiarCadena($_POST['ano']):"";
$mes = $_POST['meses'];
$dia = isset($_POST['dia'])? $conexion->limpiarCadena($_POST['dia']):"";
switch ($_GET['modulo_personal']) {
    case 'registrar':
        
        $personal->registro($primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $cedula, $civil, $correo, $ano, $mes, $dia);

    break;

    default:
        # code...
        break;
}
