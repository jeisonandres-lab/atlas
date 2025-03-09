<?php

namespace App\Atlas\controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class generateExcelController {
    private $spreadsheet;
    private $activeWorksheet;
    private $filename;

    public function __construct($filename = 'datos.xlsx') {
        $this->spreadsheet = new Spreadsheet();
        $this->activeWorksheet = $this->spreadsheet->getActiveSheet();
        $this->filename = $filename;
    }

    public function setCellValue($cell, $value) {
        $this->activeWorksheet->setCellValue($cell, $value);
    }

    public function setCellStyle($cell, $bgColor, $textColor, $fontSize, $bold = false) {
        $style = $this->activeWorksheet->getStyle($cell);

        // Color de fondo
        $style->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB($bgColor);

        // Color de texto
        $style->getFont()
            ->setColor(new Color($textColor));

        // Tamaño y negrita
        $style->getFont()
            ->setSize($fontSize)
            ->setBold($bold);
    }

    public function setCellAlignment($cell, $horizontalAlignment) {
        $style = $this->activeWorksheet->getStyle($cell);
        $style->getAlignment()->setHorizontal($horizontalAlignment);
    }

    public function mergeCells($range) {
        $this->activeWorksheet->mergeCells($range);
    }

    public function setBorders($range, $borderColor) {
        $style = $this->activeWorksheet->getStyle($range);
        $style->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $style->getBorders()->getAllBorders()->getColor()->setARGB($borderColor);
    }

    public function setColumnWidth($column, $width) {
        $this->activeWorksheet->getColumnDimension($column)->setWidth($width);
    }

    public function excelDePersonal() {
        // Generar el array de datos directamente en PHP
        $datos = [
            ['nombre' => 'Ana', 'cedula' => '98765432', 'apellido' => 'Rodríguez', 'edad' => 25, 'ciudad' => 'Caracas'],
            ['nombre' => 'Luis', 'cedula' => '23456789', 'apellido' => 'Martínez', 'edad' => 30, 'ciudad' => 'Maracay'],
            ['nombre' => 'Sofía', 'cedula' => '45678901', 'apellido' => 'Pérez', 'edad' => 28, 'ciudad' => 'Valencia'],
            ['nombre' => 'Pedro', 'cedula' => '78901234', 'apellido' => 'García', 'edad' => 35, 'ciudad' => 'Barquisimeto'],
            ['nombre' => 'Laura', 'cedula' => '01234567', 'apellido' => 'López', 'edad' => 22, 'ciudad' => 'Mérida']
        ];

        // Combinar celdas y centrar el título
        $this->mergeCells('A1:E1'); // Combinar de A1 a E1
        $this->setCellValue('A1', 'ATLAS');
        $this->setCellStyle('A1', 'FF1929BB', 'FFFFFFFF', 12, true); // Estilos para ATLAS
        $this->setCellAlignment('A1', Alignment::HORIZONTAL_CENTER); // Centrar el texto

        // Establecer las cabeceras de la tabla
        $this->setCellValue('A2', 'Nombre');
        $this->setCellValue('B2', 'Cédula');
        $this->setCellValue('C2', 'Apellido');
        $this->setCellValue('D2', 'Edad');
        $this->setCellValue('E2', 'Ciudad');

        // Estilos para las cabeceras
        $cabeceras = ['A2', 'B2', 'C2', 'D2', 'E2'];
        foreach ($cabeceras as $cabecera) {
            $this->setCellStyle($cabecera, 'FF1929BB', 'FFFFFFFF', 12,true);
            $this->setCellAlignment($cabecera, Alignment::HORIZONTAL_CENTER); // Centrar cabeceras
        }

        // Ajustar el ancho de las columnas
        $this->setColumnWidth('A', 20); // Ancho para Nombre
        $this->setColumnWidth('B', 15); // Ancho para Cédula
        $this->setColumnWidth('C', 20); // Ancho para Apellido
        $this->setColumnWidth('D', 10); // Ancho para Edad
        $this->setColumnWidth('E', 25); // Ancho para Ciudad

        // Imprimir los datos del array con colores alternados
        $fila = 3; // Comenzar en la fila 3
        $colorAlternado = true; // Iniciar con el primer color
        foreach ($datos as $dato) {
            $bgColor = $colorAlternado ? 'FFD6EAF8' : 'FFFFFFFF'; // Color alternado
            $textColor = 'FF000000'; // Color de texto negro

            $this->setCellValue('A' . $fila, $dato['nombre']);
            $this->setCellValue('B' . $fila, $dato['cedula']);
            $this->setCellValue('C' . $fila, $dato['apellido']);
            $this->setCellValue('D' . $fila, $dato['edad']);
            $this->setCellValue('E' . $fila, $dato['ciudad']);

            // Aplicar estilos a la fila
            $columnas = ['A', 'B', 'C', 'D', 'E'];
            foreach ($columnas as $columna) {
                $this->setCellStyle($columna . $fila, $bgColor, $textColor, 11);
                $this->setCellAlignment($columna . $fila, Alignment::HORIZONTAL_CENTER); //Centrar los datos
            }

            $fila++;
            $colorAlternado = !$colorAlternado; // Cambiar el color para la siguiente fila
        }
        // Aplicar bordes a toda la tabla
        $this->setBorders('A1:E' . ($fila - 1), 'FF5DADE2'); // Bordes de A1 hasta la última fila

        $writer = new Xlsx($this->spreadsheet);
        // $writer->save($this->filename);

        //Devolver el archivo para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. basename($this->filename).'"');
        header('Cache-Control: max-age=0');

        // $writer->save('php://output');
    }
}
?>