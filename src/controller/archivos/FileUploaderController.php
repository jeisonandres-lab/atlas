<?php

namespace App\Atlas\controller;

use App\Atlas\models\PersonalModel;
use App\Atlas\config\Conexion;
use App\Atlas\config\App;
use App\Atlas\controller\auditoria\AuditoriaController;


class FileUploaderController extends Conexion
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
        $this->subirDoc = new PersonalModel();
        $this->app = new App();
        $this->auditoriaController = new AuditoriaController();
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
    public function moverArchivo($file, $destination, $extension, $id_empleado, $fileInfo, $id_Nino, $nombreDoc, $cedula)
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
                "campo_nombre" => "nombreDoc",
                "campo_marcador" => ":nombreDoc",
                "campo_valor" => $nombreDoc
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
            $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Registrar documento', 'El usuario ' . $this->nombreUsuario . ' ha colocado un nuevo documento en el sistema llamado ' . $fileInfo['nombre'] . " con el código: " . $codigo . " y un tamaño de: " . $tamano);
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
    public function subirArchivo($file, $cedula, $uploadDir = null, $id_empleado, $id_Nino, $nombreDoc)
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

        // Verificar si existe una carpeta con el nombre de la cédula
        $cedulaDir = $uploadDir . '/' . $cedula;
        if (!is_dir($cedulaDir)) {
            mkdir($cedulaDir, 0777, true);
        }

        // Obtener el nombre del archivo
        $fileInfo = $this->obtenerNombreArchivo($file, $cedula);
        $fileName = $fileInfo['nombre'];
        $extension = $fileInfo['extension'];
        $destination = $cedulaDir . '/' . $fileName;

        // Validar si el archivo ya existe
        // $verificacion = $this->archivoExiste2($destination);
        // if ($verificacion['error']) {
        //     return $verificacion;
        // }

        // Mover el archivo y regresar el resultado
        return $this->moverArchivo($file, $destination, $extension, $id_empleado, $fileInfo, $id_Nino, $nombreDoc, $cedula);
    }

    // CALCULAR EL TRAMANO DE UN ARCHIVO
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

    // DESCARGAR UN ARCHIVO
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

    // GENERAR EL CODIGO DE 6 DIGITOS AL DOCUMENTO
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

    // REGISTRAR DOCUMENTO
    public function registrarArchivos(string $cedula, string $id_empleado, string|int|null $estadoCivil = null)
    {
        $fileInputs = [
            'contratoArchivo' => App::URL_CONTRATOS,
            'notacionAchivo' => App::URL_NOTACION,
            'docEstadoDerechoArchivo' => App::URL_ESTADODEDERECHO,
            'docCasadoArchivo' => App::URL_MATRIMONIO,
            'docArchivoDis' => App::URL_DISCAPACIDADEMPELADO,
            'docViudaArchivo'  => App::URL_VIUDO,
            'docDivorcioArchivo' => App::URL_DIRVORCIO,
            "docSolicEstCivilArchivo" => App::URL_SOLICITUDCAMBIOESTADOCIVIL,
            "docPartidaNacimiento" => App::URL_PARTIDANACIMIENTO
        ];

        // Determinar la carpeta de destino para docCopiaCedulaArchivo según el estado civil
        if ($estadoCivil === 'Casado') {
            $fileInputs['docCopiaCedulaArchivo'] = App::URL_COPIADECEDULACASADO;
        } elseif ($estadoCivil === 'Divorciado') {
            $fileInputs['docCopiaCedulaArchivo'] = App::URL_COPIADECEDULACAMBIOESTADOCIVIL;
        } elseif ($estadoCivil === 'Viudo') {
            $fileInputs['docCopiaCedulaArchivo'] = App::URL_COPIADECEDULAVIUDO;
        }

        $archivosASubir = [];
        foreach ($fileInputs as $inputName => $uploadDir) {
            if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
                $archivosASubir[] = [
                    'input' => $inputName,
                    'dir' => $uploadDir,
                    'nombreArchivo' => $this->getNombreArchivo($inputName, $estadoCivil)
                ];
            }
        }

        $resultados = [];
        $existeArchivo = false;
        $nombreArchivos = [];

        // Verificar si alguno de los archivos ya existe
        foreach ($archivosASubir as $archivo) {
            $inputName = $archivo['input'];
            $nombreArchivos[$inputName] = $this->obtenerNombreArchivo($_FILES[$inputName], $cedula);
            $direccion = $archivo['dir'] . $cedula . $nombreArchivos[$inputName]['nombre'];
            $existeArchivoCheck = $this->archivoExiste2($direccion);
            if ($existeArchivoCheck['error']) {
                $existeArchivo = true;
                $resultados['mensaje'] = $existeArchivoCheck['mensaje'];
                break;
            }
        }

        if ($existeArchivo) {
            $resultados['exito'] = false;
            $resultados['resultado'] = 3;
        } else {
            // Si ninguno de los archivos existe, proceder con la subida
            foreach ($archivosASubir as $archivo) {
                $inputName = $archivo['input'];
                $nombreArchivo = $archivo['nombreArchivo'];
                $direccion = $archivo['dir'];  //. $nombreArchivos[$inputName]['nombre']
                $resultados[$inputName] = $this->subirArchivo($_FILES[$inputName], $cedula, $archivo['dir'], $id_empleado, null, $nombreArchivo);
                if ($resultados[$inputName]['error']) {
                    $resultados['mensaje'] = $resultados[$inputName]['mensaje'];
                    $resultados['resultado'] = 3;
                    break;
                }
            }

            if (!isset($resultados['mensaje'])) {
                $resultados['exito'] = true;
                $resultados['mensaje'] = 'Archivos subidos exitosamente.';
            }
        }

        return $resultados;
    }

    // OBTENER NOMBRE DEL DOCUMENTO
    public function getNombreArchivo(string $inputName, $estadoCivil = null)
    {
        switch ($inputName) {
            case 'contratoArchivo':
                return 'Contrato';
            case 'notacionAchivo':
                return 'Notacion Archivo';
            case 'docEstadoDerechoArchivo':
                return 'Documento Estado De Derecho';
            case 'docCasadoArchivo':
                return 'Acta De Matrimonio';
            case 'docArchivoDis':
                return 'Acta De Discapacidad';
            case 'docViudaArchivo':
                return 'Acta De Difución';
            case 'docDivorcioArchivo':
                return 'Acta De Divorcio';
            case 'docSolicEstCivilArchivo':
                return 'Carta solicitando el cambio de estado civil';
            case 'docCopiaCedulaArchivo':
                if ($estadoCivil === 'Casado') {
                    return 'Copia de Cédula-Casado';
                } elseif ($estadoCivil === 'Divorciado') {
                    return 'Copia de Cédula-Divorciado';
                } elseif ($estadoCivil === 'Viudo') {
                    return 'Copia de Cédula-Acta De Difución';
                } else {
                    return 'Copia de Cédula';
                }
            default:
                return 'Archivo';
        }
    }
}
