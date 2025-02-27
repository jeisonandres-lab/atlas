<?php

namespace App\Atlas\controller;

use App\Atlas\models\administradorModel;
use App\Atlas\controller\auditoriaController;
use App\Atlas\config\App;
use App\Atlas\config\Conexion;
use App\Atlas\config\server;

class administradorController extends administradorModel
{
    private $auditoriaController;
    private $app;
    private $conexion;

    private $idUsuario;
    private $nombreUsuario;

    public function __construct()
    {
        parent::__construct();
        $this->app = new App();
        $this->auditoriaController = new auditoriaController();
        $this->conexion = new Conexion();
        $this->app->iniciarSession();
        $this->idUsuario = $_SESSION['id'];
        $this->nombreUsuario = $_SESSION['usuario'];
    }

    public function datosMasivosUsuario($nombreUser)
    {
        $nombreUser = $this->limpiarCadena($nombreUser);
        $data_json = [
            'exito' => false,
            'messenger' => 'No se pudo obtener los datos de la dependencia',
        ];

        if (empty($nombreUser)) {
            $sql = $this->totaldatosMasivosTodoUsuarios();
        } elseif (ctype_digit($nombreUser)) {
            // Si $nombreUser contiene solo números
            $parametros = [
                '1' => '%act%',
                '2' => '%regis%',
                '3' => '%descar%'
            ];

            if (array_key_exists($nombreUser, $parametros)) {
                $sql = $this->totaldatosMasivosTodoUsuariosTIPOEVENTO([$parametros[$nombreUser]]);
            } else {
                $sql = false;
            }
        } else {
            // Si $nombreUser contiene texto (letras o combinación de letras y números)
            $sql = $this->totaldatosMasivosUsuario([$nombreUser]); // Ejemplo de otra función
        }

        if ($sql) {
            $data_json['exito'] = true;
            $data_json['messenger'] = 'datos encontrados';
            $data_json['data'] = $sql;
        }

        // Devolver la respuesta en formato JSON
        header('Content-Type: application/json');
        echo json_encode($data_json);
    }

    public function descargarBaseDatos()
    {
        $data_json = [
            'exito' => false,
            'messenger' => 'NO SE PUEDE DESCARGAR LOS DATOS DE LA BVASE DE DATOS',
        ];

        $backupFile = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $mysqldumpPath = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
        $command = "\"$mysqldumpPath\" --user=" . server::DB_USER . " --password=" . server::DB_PASS . " --host=" . server::DB_SERVER . " " . server::DB_NAME . " > " . $backupFile;

        // Para depuración: imprime el comando que se está ejecutando
        echo "Ejecutando comando: $command\n";

        exec($command . ' 2>&1', $output, $return_var);

        // Para depuración: imprime el resultado del comando
        echo "Resultado del comando: $return_var\n";
        echo "Salida del comando: " . implode("\n", $output) . "\n";

        if ($return_var === 0) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($backupFile));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($backupFile));
            readfile($backupFile);
            // No eliminar el archivo después de la descarga
            // unlink($backupFile);
            $data_json['exito'] = true;
            $data_json['messenger'] = 'Ya se logro descargar la base de datos';
        } else {

        }

        header('Content-Type: application/json');
        echo json_encode($data_json);
    }
}
