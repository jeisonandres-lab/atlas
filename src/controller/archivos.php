<?php

namespace App\Atlas\controller;

class archivo
{
    public function datosArchivos()
    {
        $datosArchivos = [];
        // Iteramos sobre todos los elementos de $_FILES
        foreach ($_FILES as $input => $fileInfo) {
            if (is_array($fileInfo['name'])) {
                // Si es un array (múltiples archivos), iteramos sobre cada archivo
                foreach ($fileInfo['name'] as $key => $value) {
                    $nuevo_elemento = [
                        "campo_nombre" => "nombre_archivo",
                        "campo_marcador" => ":nombre_archivo",
                        "campo_valor" => $value
                    ];
                    // Agregar el nuevo elemento al array principal
                    $datosArchivos[] = $nuevo_elemento;
                }
            } else {
                // Si es un solo archivo, lo agregamos directamente
                $nuevo_elemento = [
                    "campo_nombre" => "nombre_archivo",
                    "campo_marcador" => ":nombre_archivo",
                    "campo_valor" => $fileInfo['name']
                ];
                // Agregar el nuevo elemento al array principal
                $datosArchivos[] = $nuevo_elemento;
            }
        }
        return $datosArchivos;
    }

    public function moverArchivo(string $archivo, $ruta){}

    public function eliminarArchivo(string $archivo, $ruta){}
}


