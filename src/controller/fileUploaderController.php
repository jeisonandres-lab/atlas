<?php

namespace App\Atlas\controller;

class fileUploaderController
{
    private $allowedExtensions;
    private $defaultUploadDir;

    public function __construct($allowedExtensions = ['pdf', 'png', 'jpeg', 'jpg'], $defaultUploadDir = '../config/')
    {
        $this->allowedExtensions = $allowedExtensions;
        $this->defaultUploadDir = $defaultUploadDir;
    }

    public function uploadMultiple($fileInputNames, $uploadDirs, $cedula)
    {
        $resultados = [];
        foreach ($fileInputNames as $index => $fileInputName) {
            if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] == UPLOAD_ERR_OK) {
                $uploadDir = $uploadDirs[$index] ?? null;
                $resultado = $this->upload($_FILES[$fileInputName], $uploadDir, $cedula);
                $resultados[$fileInputName] = $resultado;
            } else {
                $resultados[$fileInputName] = ['error' => true, 'mensaje' => 'No se subió el archivo ' . $fileInputName];
            }
        }
        return $resultados;
    }

    public function upload($file, $uploadDir = null, $cedula)
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

        // Eliminar espacios en blanco del nombre del archivo
        $fileName = preg_replace('/\s+/', '_', pathinfo($file['name'], PATHINFO_FILENAME)) . '-' . $cedula . '.' . $extension;
        $destination = $uploadDir . $fileName;

        // Validar si el archivo ya existe
        if (file_exists($destination)) {
            return ['error' => true, 'mensaje' => 'El archivo ya existe o tiene el mismo nombre que otro archivo'];
        }

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return [
                'error' => false,
                'mensaje' => 'Archivo subido con éxito',
                'ruta' => $destination,
                'nombre' => $fileName,
                'extension' => $extension,
                'tamano' => $this->formatSizeUnits($file['size']), // Añadir el tamaño del archivo con formato legible
                'codigo' => $this->generarCodigoAleatorio(6)
            ];

        } else {
            return ['error' => true, 'mensaje' => 'Error al subir el archivo'];
        }
    }

    private function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
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
}
