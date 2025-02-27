<?php

namespace App\Atlas\controller;

use App\Atlas\models\personalModel;
use App\Atlas\config\Conexion;
use App\Atlas\controller\auditoriaController;
use App\Atlas\config\App;

class fileUploaderController extends Conexion
{
    private $allowedExtensions;
    private $defaultUploadDir;
    private $subirDoc;

    private $auditoriaController;
    private $app;

    private $idUsuario;
    private $nombreUsuario;

    public function __construct($allowedExtensions = ['pdf', 'png', 'jpeg', 'jpg'], $defaultUploadDir = '../config/')
    {
        parent::__construct();
        $this->allowedExtensions = $allowedExtensions;
        $this->defaultUploadDir = $defaultUploadDir;
        $this->subirDoc = new personalModel();
        $this->app = new App();
        $this->auditoriaController = new auditoriaController();
        $this->app->iniciarSession();
        $this->idUsuario = $_SESSION['id'];
        $this->nombreUsuario = $_SESSION['usuario'];
    }
    /**
     * Obtiene el nombre del archivo y su extensión.
     *
     * @param array $file Información del archivo subido.
     * @param string $cedula Identificador único para el archivo.
     * @return array Nombre del archivo y su extensión.
     */
    public function obtenerNombreArchivo($file, $cedula)
    {
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $fileName = preg_replace('/\s+/', '_', pathinfo($file['name'], PATHINFO_FILENAME)) . '-' . $cedula . '.' . $extension;
        return ['nombre' => $fileName, 'extension' => $extension];
    }

    /**
     * Verifica si un archivo ya existe en el directorio.
     *
     * @param string $destination Ruta completa del archivo a verificar.
     * @return array Resultado de la verificación.
     */
    public function archivoExiste2($destination)
    {
        if (file_exists($destination)) {
            return ['error' => true, 'mensaje' => 'El archivo ya existe o tiene el mismo nombre que otro archivo'];
        } else {
            return ['error' => false, 'mensaje' => 'El archivo no existe y puede ser subido'];
        }
    }

    /**
     * Mueve el archivo subido al directorio de destino.
     *
     * @param array $file Información del archivo subido.
     * @param string $destination Ruta completa del archivo de destino.
     * @param string $extension Extensión del archivo.
     * @return array Resultado de la operación de subida.
     */
    public function moverArchivo($file, $destination, $extension, $id_empleado, $fileInfo, $id_Nino)
    {
        $tamano = $this->formatSizeUnits($file['size']); // Añadir el tamaño del archivo con formato legible
        $codigo = $this->generarCodigoAleatorio(6);
        $parametros_doc = [
            [
                "campo_nombre" => "idEmpleados",
                "campo_marcador" => ":idEmpleados",
                "campo_valor" => $id_empleado
            ],
            [
                "campo_nombre" => "idNinos",
                "campo_marcador" => ":idNinos",
                "campo_valor" => $id_Nino
            ],
            [
                "campo_nombre" => "size",
                "campo_marcador" => ":size",
                "campo_valor" => $tamano
            ],
            [
                "campo_nombre" => "doc",
                "campo_marcador" => ":doc",
                "campo_valor" => $fileInfo['nombre']
            ],
            [
                "campo_nombre" => "tipoDoc",
                "campo_marcador" => ":tipoDoc",
                "campo_valor" => $extension
            ],
            [
                "campo_nombre" => "fecha",
                "campo_marcador" => ":fecha",
                "campo_valor" => date("Y-m-d")
            ],
            [
                "campo_nombre" => "hora",
                "campo_marcador" => ":hora",
                "campo_valor" => date("h:i:s A")
            ]
        ];
        $tabla = 'documentacion';
        $cargarDOC = $this->subirDoc->getRegistrarDOCS($tabla, $parametros_doc);
        if ($cargarDOC) {
            $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Registrar documento', 'El usuario ' . $this->nombreUsuario . ' ha colocado un nuevo documento en el sistema llamado '. $fileInfo['nombre']. " con el código: ".$codigo. " y un tamaño de: ".$tamano);
            if ($registroAuditoria) {
                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    return [
                        'error' => false,
                        'mensaje' => 'Archivo subido con éxito',
                        'ruta' => $destination,
                        'nombre' => $fileInfo['nombre'],
                        'extension' => $extension,
                        'tamano' => $tamano, // Añadir el tamaño del archivo con formato legible
                        'codigo' => $codigo,
                        'Auditoria' => "Auditoria registrada"
                    ];
                } else {
                    return ['error' => true, 'mensaje' => 'Error al mover el archivo'];
                }
            } else {
                return [
                    'error' => true,
                    'mensaje' => 'error al cargar los datos del archivo en la bse de datos',
                ];
            }
        } else {
            return [
                'error' => true,
                'mensaje' => 'error al cargar los datos del archivo en la bse de datos',
            ];
        }
    }

    /**
     * Función principal para manejar la subida de archivos.
     *
     * @param array $file Información del archivo subido.
     * @param string $cedula Identificador único para el archivo.
     * @param string|null $uploadDir Directorio de subida (opcional).
     * @return array Resultado de la operación de subida.
     */
    public function subirArchivo($file, $cedula, $uploadDir = null, $id_empleado, $id_Nino)
    {
        if (!isset($file)) {
            return ['error' => true, 'mensaje' => 'No se ha subido ningún archivo'];
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $this->allowedExtensions)) {
            return ['error' => true, 'mensaje' => "El archivo no es de un tipo permitido"];
        }

        // Usar la ruta de destino proporcionada o la ruta por defecto
        $uploadDir = $uploadDir ?? $this->defaultUploadDir;

        // Crear el directorio si no existe
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Obtener el nombre del archivo
        $fileInfo = $this->obtenerNombreArchivo($file, $cedula);
        $fileName = $fileInfo['nombre'];
        $extension = $fileInfo['extension'];
        $destination = $uploadDir . $fileName;

        // Validar si el archivo ya existe
        // $verificacion = $this->archivoExiste2($destination);
        // if ($verificacion['error']) {
        //     return $verificacion;
        // }

        // Mover el archivo y regresar el resultado
        return $this->moverArchivo($file, $destination, $extension, $id_empleado, $fileInfo, $id_Nino);
    }

    private function formatSizeUnits($bytes)
    {
        // if ($bytes >= 1024) {
        //     $bytes = number_format($bytes / 1024, 2) . ' KB';
        // } elseif ($bytes > 1) {
        //     $bytes = number_format($bytes / 1024, 2) . ' KB'; // También lo convierte si es menor a 1KB
        // } elseif ($bytes == 1) {
        //     $bytes = '0.00 KB'; // o '0 KB' si prefieres mostrar 0
        // } else {
        //     $bytes = '0.00 KB';  // o '0 KB'
        // }
        return number_format($bytes / 1024, 2) . ' KB';
    }

    public function download($fileName)
    {
        $filePath = $this->defaultUploadDir . $fileName;

        if (!file_exists($filePath)) {
            return ['error' => true, 'mensaje' => 'El archivo no existe'];
        }

        // Enviar encabezados para la descarga del archivo
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        // Leer el archivo y enviarlo al navegador
        readfile($filePath);
        exit;
    }

    private function generarCodigoAleatorio($longitud = 6)
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longitudCaracteres = strlen($caracteres);
        $codigo = '';
        for ($i = 0; $i < $longitud; $i++) {
            $codigo .= $caracteres[mt_rand(0, $longitudCaracteres - 1)];
        }
        return $codigo;
    }

















    // Otras funciones como formatSizeUnits y generarCodigoAleatorio


}
