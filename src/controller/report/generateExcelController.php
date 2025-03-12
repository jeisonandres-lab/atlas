<?php

namespace App\Atlas\controller\report;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use App\Atlas\models\personalModel;
use App\Atlas\controller\auditoriaController;
use App\Atlas\config\App;

class generateExcelController {
    private $spreadsheet;
    private $activeWorksheet;
    private $filename;
    private $personalModel;
    private $app;
    private $auditoriaController;
    private $idUsuario;
    private $nombreUsuario;

    public function __construct($filename = 'datos.xlsx') {
        $this->spreadsheet = new Spreadsheet();
        $this->activeWorksheet = $this->spreadsheet->getActiveSheet();
        $this->filename = $filename;
        $this->personalModel = new personalModel();
        $this->app = new App();
        $this->auditoriaController = new auditoriaController();
        $this->app->iniciarSession();
        $this->idUsuario = $_SESSION['id'];
        $this->nombreUsuario = $_SESSION['usuario'];
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

    //FILTRAR POR SEXUALIDAD
    public function excelEmepleadoSexualidad($sexo) {
        // Generar el array de datos directamente en PHP
        $datos = $this->personalModel->getDatosEmpleadoFiltro('dp.sexo = ?',[$sexo]);

        // Combinar celdas y centrar el título
        $this->mergeCells('A1:P1'); // Combinar de A1 a E1
        $this->setCellValue('A1', 'ATLAS');
        $this->setCellStyle('A1', 'FF1929BB', 'FFFFFFFF', 12, true); // Estilos para ATLAS
        $this->setCellAlignment('A1', Alignment::HORIZONTAL_CENTER); // Centrar el texto

        // Establecer las cabeceras de la tabla
        $this->setCellValue('A2', 'Primer Nombre');
        $this->setCellValue('B2', 'Segundo Nombre');
        $this->setCellValue('C2', 'Primer Apellido');
        $this->setCellValue('D2', 'Segundo Nombre');
        $this->setCellValue('E2', 'Cédula');
        $this->setCellValue('F2', 'Estado Civil');
        $this->setCellValue('G2', 'Sexualidad');
        $this->setCellValue('H2', 'Fecha De N.');
        $this->setCellValue('I2', 'Edad');
        $this->setCellValue('J2', 'Estatus');
        $this->setCellValue('K2', 'Cargo');
        $this->setCellValue('L2', 'Nivel Academico');
        $this->setCellValue('M2', 'Telefono Personal');
        $this->setCellValue('N2', 'Fecha De ING');
        $this->setCellValue('O2', 'Dependencia');
        $this->setCellValue('P2', 'Departamento');


        // Estilos para las cabeceras
        $cabeceras = ['A2', 'B2', 'C2', 'D2', 'E2', 'F2', 'G2', 'H2', 'I2', 'J2', 'K2', 'L2', 'M2', 'N2', 'O2', 'P2'];
        foreach ($cabeceras as $cabecera) {
            $this->setCellStyle($cabecera, 'FF1929BB', 'FFFFFFFF', 12,true);
            $this->setCellAlignment($cabecera, Alignment::HORIZONTAL_CENTER); // Centrar cabeceras
        }

        // Ajustar el ancho de las columnas
        $this->setColumnWidth('A', 20);
        $this->setColumnWidth('B', 20);
        $this->setColumnWidth('C', 20);
        $this->setColumnWidth('D', 20);
        $this->setColumnWidth('E', 20);
        $this->setColumnWidth('F', 20);
        $this->setColumnWidth('G', 20);
        $this->setColumnWidth('H', 20);
        $this->setColumnWidth('I', 10);
        $this->setColumnWidth('J', 30);
        $this->setColumnWidth('K', 30);
        $this->setColumnWidth('L', 30);
        $this->setColumnWidth('M', 30);
        $this->setColumnWidth('N', 20);
        $this->setColumnWidth('O', 60);
        $this->setColumnWidth('P', 60);


        // Imprimir los datos del array con colores alternados
        $fila = 3; // Comenzar en la fila 3
        $colorAlternado = true; // Iniciar con el primer color
        foreach ($datos as $dato) {
            $bgColor = $colorAlternado ? 'FFD6EAF8' : 'FFFFFFFF'; // Color alternado
            $textColor = 'FF000000'; // Color de texto negro

            $this->setCellValue('A' . $fila, $dato['primerNombre']);
            $this->setCellValue('B' . $fila, $dato['segundoNombre']);
            $this->setCellValue('C' . $fila, $dato['primerApellido']);
            $this->setCellValue('D' . $fila, $dato['segundoApellido']);
            $this->setCellValue('E' . $fila, $dato['cedula']);
            $this->setCellValue('F' . $fila, $dato['estadoCivil']);
            $this->setCellValue('G' . $fila, $dato['sexo']);
            $this->setCellValue('H' . $fila, $dato['diaNacimiento']."-".$dato['mesNacimiento']."-".$dato['anoNacimiento']);
            $this->setCellValue('I' . $fila, $dato['edadPersonal']);
            $this->setCellValue('J' . $fila, $dato['cargo']);
            $this->setCellValue('K' . $fila, $dato['estatus']);
            $this->setCellValue('L' . $fila, $dato['nivelAcademico']);
            $this->setCellValue('M' . $fila, $dato['telefono']);
            $this->setCellValue('N' . $fila, $dato['fechaCreada']);
            $this->setCellValue('O' . $fila, $dato['dependencia']);
            $this->setCellValue('P' . $fila, $dato['departamento']);



            // Aplicar estilos a la fila
            $columnas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P'];
            foreach ($columnas as $columna) {
                $this->setCellStyle($columna . $fila, $bgColor, $textColor, 11);
                $this->setCellAlignment($columna . $fila, Alignment::HORIZONTAL_CENTER); //Centrar los datos
            }

            $fila++;
            $colorAlternado = !$colorAlternado; // Cambiar el color para la siguiente fila
        }
        // Aplicar bordes a toda la tabla
        $this->setBorders('A1:P' . ($fila - 1), 'FF5DADE2'); // Bordes de A1 hasta la última fila

        $writer = new Xlsx($this->spreadsheet);
        // $writer->save($this->filename);

        //Devolver el archivo para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. basename($this->filename).'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //FITRAR SU EDAD
    public function generarExceledad(string $edad){
        // Generar el array de datos directamente en PHP
        $datos = $this->personalModel->getDatosEmpleadoFiltro('dp.edadPersonal = ?',[$edad]);

        // Combinar celdas y centrar el título
        $this->mergeCells('A1:P1'); // Combinar de A1 a E1
        $this->setCellValue('A1', 'ATLAS');
        $this->setCellStyle('A1', 'FF1929BB', 'FFFFFFFF', 12, true); // Estilos para ATLAS
        $this->setCellAlignment('A1', Alignment::HORIZONTAL_CENTER); // Centrar el texto

        // Establecer las cabeceras de la tabla
        $this->setCellValue('A2', 'Primer Nombre');
        $this->setCellValue('B2', 'Segundo Nombre');
        $this->setCellValue('C2', 'Primer Apellido');
        $this->setCellValue('D2', 'Segundo Nombre');
        $this->setCellValue('E2', 'Cédula');
        $this->setCellValue('F2', 'Estado Civil');
        $this->setCellValue('G2', 'Sexualidad');
        $this->setCellValue('H2', 'Fecha De N.');
        $this->setCellValue('I2', 'Edad');
        $this->setCellValue('J2', 'Estatus');
        $this->setCellValue('K2', 'Cargo');
        $this->setCellValue('L2', 'Nivel Academico');
        $this->setCellValue('M2', 'Telefono Personal');
        $this->setCellValue('N2', 'Fecha De ING');
        $this->setCellValue('O2', 'Dependencia');
        $this->setCellValue('P2', 'Departamento');


        // Estilos para las cabeceras
        $cabeceras = ['A2', 'B2', 'C2', 'D2', 'E2', 'F2', 'G2', 'H2', 'I2', 'J2', 'K2', 'L2', 'M2', 'N2', 'O2', 'P2'];
        foreach ($cabeceras as $cabecera) {
            $this->setCellStyle($cabecera, 'FF1929BB', 'FFFFFFFF', 12,true);
            $this->setCellAlignment($cabecera, Alignment::HORIZONTAL_CENTER); // Centrar cabeceras
        }

        // Ajustar el ancho de las columnas
        $this->setColumnWidth('A', 20);
        $this->setColumnWidth('B', 20);
        $this->setColumnWidth('C', 20);
        $this->setColumnWidth('D', 20);
        $this->setColumnWidth('E', 20);
        $this->setColumnWidth('F', 20);
        $this->setColumnWidth('G', 20);
        $this->setColumnWidth('H', 20);
        $this->setColumnWidth('I', 10);
        $this->setColumnWidth('J', 30);
        $this->setColumnWidth('K', 30);
        $this->setColumnWidth('L', 30);
        $this->setColumnWidth('M', 30);
        $this->setColumnWidth('N', 20);
        $this->setColumnWidth('O', 60);
        $this->setColumnWidth('P', 60);


        // Imprimir los datos del array con colores alternados
        $fila = 3; // Comenzar en la fila 3
        $colorAlternado = true; // Iniciar con el primer color
        foreach ($datos as $dato) {
            $bgColor = $colorAlternado ? 'FFD6EAF8' : 'FFFFFFFF'; // Color alternado
            $textColor = 'FF000000'; // Color de texto negro

            $this->setCellValue('A' . $fila, $dato['primerNombre']);
            $this->setCellValue('B' . $fila, $dato['segundoNombre']);
            $this->setCellValue('C' . $fila, $dato['primerApellido']);
            $this->setCellValue('D' . $fila, $dato['segundoApellido']);
            $this->setCellValue('E' . $fila, $dato['cedula']);
            $this->setCellValue('F' . $fila, $dato['estadoCivil']);
            $this->setCellValue('G' . $fila, $dato['sexo']);
            $this->setCellValue('H' . $fila, $dato['diaNacimiento']."-".$dato['mesNacimiento']."-".$dato['anoNacimiento']);
            $this->setCellValue('I' . $fila, $dato['edadPersonal']);
            $this->setCellValue('J' . $fila, $dato['cargo']);
            $this->setCellValue('K' . $fila, $dato['estatus']);
            $this->setCellValue('L' . $fila, $dato['nivelAcademico']);
            $this->setCellValue('M' . $fila, $dato['telefono']);
            $this->setCellValue('N' . $fila, $dato['fechaCreada']);
            $this->setCellValue('O' . $fila, $dato['dependencia']);
            $this->setCellValue('P' . $fila, $dato['departamento']);



            // Aplicar estilos a la fila
            $columnas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P'];
            foreach ($columnas as $columna) {
                $this->setCellStyle($columna . $fila, $bgColor, $textColor, 11);
                $this->setCellAlignment($columna . $fila, Alignment::HORIZONTAL_CENTER); //Centrar los datos
            }

            $fila++;
            $colorAlternado = !$colorAlternado; // Cambiar el color para la siguiente fila
        }
        // Aplicar bordes a toda la tabla
        $this->setBorders('A1:P' . ($fila - 1), 'FF5DADE2'); // Bordes de A1 hasta la última fila

        $writer = new Xlsx($this->spreadsheet);
        // $writer->save($this->filename);

        //Devolver el archivo para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. basename($this->filename).'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //FILTRAR POR CARGO
    public function  generarExcelCargo(string $cargo){
        // Generar el array de datos directamente en PHP
        $datos = $this->personalModel->getDatosEmpleadoFiltro('c.id_cargo = ?',[$cargo]);

        // Combinar celdas y centrar el título
        $this->mergeCells('A1:P1'); // Combinar de A1 a E1
        $this->setCellValue('A1', 'ATLAS');
        $this->setCellStyle('A1', 'FF1929BB', 'FFFFFFFF', 12, true); // Estilos para ATLAS
        $this->setCellAlignment('A1', Alignment::HORIZONTAL_CENTER); // Centrar el texto

        // Establecer las cabeceras de la tabla
        $this->setCellValue('A2', 'Primer Nombre');
        $this->setCellValue('B2', 'Segundo Nombre');
        $this->setCellValue('C2', 'Primer Apellido');
        $this->setCellValue('D2', 'Segundo Nombre');
        $this->setCellValue('E2', 'Cédula');
        $this->setCellValue('F2', 'Estado Civil');
        $this->setCellValue('G2', 'Sexualidad');
        $this->setCellValue('H2', 'Fecha De N.');
        $this->setCellValue('I2', 'Edad');
        $this->setCellValue('J2', 'Estatus');
        $this->setCellValue('K2', 'Cargo');
        $this->setCellValue('L2', 'Nivel Academico');
        $this->setCellValue('M2', 'Telefono Personal');
        $this->setCellValue('N2', 'Fecha De ING');
        $this->setCellValue('O2', 'Dependencia');
        $this->setCellValue('P2', 'Departamento');


        // Estilos para las cabeceras
        $cabeceras = ['A2', 'B2', 'C2', 'D2', 'E2', 'F2', 'G2', 'H2', 'I2', 'J2', 'K2', 'L2', 'M2', 'N2', 'O2', 'P2'];
        foreach ($cabeceras as $cabecera) {
            $this->setCellStyle($cabecera, 'FF1929BB', 'FFFFFFFF', 12,true);
            $this->setCellAlignment($cabecera, Alignment::HORIZONTAL_CENTER); // Centrar cabeceras
        }

        // Ajustar el ancho de las columnas
        $this->setColumnWidth('A', 20);
        $this->setColumnWidth('B', 20);
        $this->setColumnWidth('C', 20);
        $this->setColumnWidth('D', 20);
        $this->setColumnWidth('E', 20);
        $this->setColumnWidth('F', 20);
        $this->setColumnWidth('G', 20);
        $this->setColumnWidth('H', 20);
        $this->setColumnWidth('I', 10);
        $this->setColumnWidth('J', 30);
        $this->setColumnWidth('K', 30);
        $this->setColumnWidth('L', 30);
        $this->setColumnWidth('M', 30);
        $this->setColumnWidth('N', 20);
        $this->setColumnWidth('O', 60);
        $this->setColumnWidth('P', 60);


        // Imprimir los datos del array con colores alternados
        $fila = 3; // Comenzar en la fila 3
        $colorAlternado = true; // Iniciar con el primer color
        foreach ($datos as $dato) {
            $bgColor = $colorAlternado ? 'FFD6EAF8' : 'FFFFFFFF'; // Color alternado
            $textColor = 'FF000000'; // Color de texto negro

            $this->setCellValue('A' . $fila, $dato['primerNombre']);
            $this->setCellValue('B' . $fila, $dato['segundoNombre']);
            $this->setCellValue('C' . $fila, $dato['primerApellido']);
            $this->setCellValue('D' . $fila, $dato['segundoApellido']);
            $this->setCellValue('E' . $fila, $dato['cedula']);
            $this->setCellValue('F' . $fila, $dato['estadoCivil']);
            $this->setCellValue('G' . $fila, $dato['sexo']);
            $this->setCellValue('H' . $fila, $dato['diaNacimiento']."-".$dato['mesNacimiento']."-".$dato['anoNacimiento']);
            $this->setCellValue('I' . $fila, $dato['edadPersonal']);
            $this->setCellValue('J' . $fila, $dato['cargo']);
            $this->setCellValue('K' . $fila, $dato['estatus']);
            $this->setCellValue('L' . $fila, $dato['nivelAcademico']);
            $this->setCellValue('M' . $fila, $dato['telefono']);
            $this->setCellValue('N' . $fila, $dato['fechaCreada']);
            $this->setCellValue('O' . $fila, $dato['dependencia']);
            $this->setCellValue('P' . $fila, $dato['departamento']);



            // Aplicar estilos a la fila
            $columnas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P'];
            foreach ($columnas as $columna) {
                $this->setCellStyle($columna . $fila, $bgColor, $textColor, 11);
                $this->setCellAlignment($columna . $fila, Alignment::HORIZONTAL_CENTER); //Centrar los datos
            }

            $fila++;
            $colorAlternado = !$colorAlternado; // Cambiar el color para la siguiente fila
        }
        // Aplicar bordes a toda la tabla
        $this->setBorders('A1:P' . ($fila - 1), 'FF5DADE2'); // Bordes de A1 hasta la última fila

        $writer = new Xlsx($this->spreadsheet);
        // $writer->save($this->filename);

        //Devolver el archivo para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. basename($this->filename).'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //FILTAR POR ESTATUS
    public function generarExcelEstatus(string $estatus){
        // Generar el array de datos directamente en PHP
        $datos = $this->personalModel->getDatosEmpleadoFiltro('e.id_estatus = ?',[$estatus]);


        // Combinar celdas y centrar el título
        $this->mergeCells('A1:P1'); // Combinar de A1 a E1
        $this->setCellValue('A1', 'ATLAS');
        $this->setCellStyle('A1', 'FF1929BB', 'FFFFFFFF', 12, true); // Estilos para ATLAS
        $this->setCellAlignment('A1', Alignment::HORIZONTAL_CENTER); // Centrar el texto

        // Establecer las cabeceras de la tabla
        $this->setCellValue('A2', 'Primer Nombre');
        $this->setCellValue('B2', 'Segundo Nombre');
        $this->setCellValue('C2', 'Primer Apellido');
        $this->setCellValue('D2', 'Segundo Nombre');
        $this->setCellValue('E2', 'Cédula');
        $this->setCellValue('F2', 'Estado Civil');
        $this->setCellValue('G2', 'Sexualidad');
        $this->setCellValue('H2', 'Fecha De N.');
        $this->setCellValue('I2', 'Edad');
        $this->setCellValue('J2', 'Estatus');
        $this->setCellValue('K2', 'Cargo');
        $this->setCellValue('L2', 'Nivel Academico');
        $this->setCellValue('M2', 'Telefono Personal');
        $this->setCellValue('N2', 'Fecha De ING');
        $this->setCellValue('O2', 'Dependencia');
        $this->setCellValue('P2', 'Departamento');


        // Estilos para las cabeceras
        $cabeceras = ['A2', 'B2', 'C2', 'D2', 'E2', 'F2', 'G2', 'H2', 'I2', 'J2', 'K2', 'L2', 'M2', 'N2', 'O2', 'P2'];
        foreach ($cabeceras as $cabecera) {
            $this->setCellStyle($cabecera, 'FF1929BB', 'FFFFFFFF', 12,true);
            $this->setCellAlignment($cabecera, Alignment::HORIZONTAL_CENTER); // Centrar cabeceras
        }

        // Ajustar el ancho de las columnas
        $this->setColumnWidth('A', 20);
        $this->setColumnWidth('B', 20);
        $this->setColumnWidth('C', 20);
        $this->setColumnWidth('D', 20);
        $this->setColumnWidth('E', 20);
        $this->setColumnWidth('F', 20);
        $this->setColumnWidth('G', 20);
        $this->setColumnWidth('H', 20);
        $this->setColumnWidth('I', 10);
        $this->setColumnWidth('J', 30);
        $this->setColumnWidth('K', 30);
        $this->setColumnWidth('L', 30);
        $this->setColumnWidth('M', 30);
        $this->setColumnWidth('N', 20);
        $this->setColumnWidth('O', 60);
        $this->setColumnWidth('P', 60);


        // Imprimir los datos del array con colores alternados
        $fila = 3; // Comenzar en la fila 3
        $colorAlternado = true; // Iniciar con el primer color
        foreach ($datos as $dato) {
            $bgColor = $colorAlternado ? 'FFD6EAF8' : 'FFFFFFFF'; // Color alternado
            $textColor = 'FF000000'; // Color de texto negro

            $this->setCellValue('A' . $fila, $dato['primerNombre']);
            $this->setCellValue('B' . $fila, $dato['segundoNombre']);
            $this->setCellValue('C' . $fila, $dato['primerApellido']);
            $this->setCellValue('D' . $fila, $dato['segundoApellido']);
            $this->setCellValue('E' . $fila, $dato['cedula']);
            $this->setCellValue('F' . $fila, $dato['estadoCivil']);
            $this->setCellValue('G' . $fila, $dato['sexo']);
            $this->setCellValue('H' . $fila, $dato['diaNacimiento']."-".$dato['mesNacimiento']."-".$dato['anoNacimiento']);
            $this->setCellValue('I' . $fila, $dato['edadPersonal']);
            $this->setCellValue('J' . $fila, $dato['cargo']);
            $this->setCellValue('K' . $fila, $dato['estatus']);
            $this->setCellValue('L' . $fila, $dato['nivelAcademico']);
            $this->setCellValue('M' . $fila, $dato['telefono']);
            $this->setCellValue('N' . $fila, $dato['fechaCreada']);
            $this->setCellValue('O' . $fila, $dato['dependencia']);
            $this->setCellValue('P' . $fila, $dato['departamento']);



            // Aplicar estilos a la fila
            $columnas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P'];
            foreach ($columnas as $columna) {
                $this->setCellStyle($columna . $fila, $bgColor, $textColor, 11);
                $this->setCellAlignment($columna . $fila, Alignment::HORIZONTAL_CENTER); //Centrar los datos
            }

            $fila++;
            $colorAlternado = !$colorAlternado; // Cambiar el color para la siguiente fila
        }
        // Aplicar bordes a toda la tabla
        $this->setBorders('A1:P' . ($fila - 1), 'FF5DADE2'); // Bordes de A1 hasta la última fila

        $writer = new Xlsx($this->spreadsheet);
        // $writer->save($this->filename);

        //Devolver el archivo para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. basename($this->filename).'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //FILTAR POR ESTADO CIVIL
    public function generarExcelestadoCivil(string $estadoCivil){
        // Generar el array de datos directamente en PHP
        $datos = $this->personalModel->getDatosEmpleadoFiltro('dp.estadoCivil = ?',[$estadoCivil]);


        // Combinar celdas y centrar el título
        $this->mergeCells('A1:P1'); // Combinar de A1 a E1
        $this->setCellValue('A1', 'ATLAS');
        $this->setCellStyle('A1', 'FF1929BB', 'FFFFFFFF', 12, true); // Estilos para ATLAS
        $this->setCellAlignment('A1', Alignment::HORIZONTAL_CENTER); // Centrar el texto

        // Establecer las cabeceras de la tabla
        $this->setCellValue('A2', 'Primer Nombre');
        $this->setCellValue('B2', 'Segundo Nombre');
        $this->setCellValue('C2', 'Primer Apellido');
        $this->setCellValue('D2', 'Segundo Nombre');
        $this->setCellValue('E2', 'Cédula');
        $this->setCellValue('F2', 'Estado Civil');
        $this->setCellValue('G2', 'Sexualidad');
        $this->setCellValue('H2', 'Fecha De N.');
        $this->setCellValue('I2', 'Edad');
        $this->setCellValue('J2', 'Estatus');
        $this->setCellValue('K2', 'Cargo');
        $this->setCellValue('L2', 'Nivel Academico');
        $this->setCellValue('M2', 'Telefono Personal');
        $this->setCellValue('N2', 'Fecha De ING');
        $this->setCellValue('O2', 'Dependencia');
        $this->setCellValue('P2', 'Departamento');


        // Estilos para las cabeceras
        $cabeceras = ['A2', 'B2', 'C2', 'D2', 'E2', 'F2', 'G2', 'H2', 'I2', 'J2', 'K2', 'L2', 'M2', 'N2', 'O2', 'P2'];
        foreach ($cabeceras as $cabecera) {
            $this->setCellStyle($cabecera, 'FF1929BB', 'FFFFFFFF', 12,true);
            $this->setCellAlignment($cabecera, Alignment::HORIZONTAL_CENTER); // Centrar cabeceras
        }

        // Ajustar el ancho de las columnas
        $this->setColumnWidth('A', 20);
        $this->setColumnWidth('B', 20);
        $this->setColumnWidth('C', 20);
        $this->setColumnWidth('D', 20);
        $this->setColumnWidth('E', 20);
        $this->setColumnWidth('F', 20);
        $this->setColumnWidth('G', 20);
        $this->setColumnWidth('H', 20);
        $this->setColumnWidth('I', 10);
        $this->setColumnWidth('J', 30);
        $this->setColumnWidth('K', 30);
        $this->setColumnWidth('L', 30);
        $this->setColumnWidth('M', 30);
        $this->setColumnWidth('N', 20);
        $this->setColumnWidth('O', 60);
        $this->setColumnWidth('P', 60);


        // Imprimir los datos del array con colores alternados
        $fila = 3; // Comenzar en la fila 3
        $colorAlternado = true; // Iniciar con el primer color
        foreach ($datos as $dato) {
            $bgColor = $colorAlternado ? 'FFD6EAF8' : 'FFFFFFFF'; // Color alternado
            $textColor = 'FF000000'; // Color de texto negro

            $this->setCellValue('A' . $fila, $dato['primerNombre']);
            $this->setCellValue('B' . $fila, $dato['segundoNombre']);
            $this->setCellValue('C' . $fila, $dato['primerApellido']);
            $this->setCellValue('D' . $fila, $dato['segundoApellido']);
            $this->setCellValue('E' . $fila, $dato['cedula']);
            $this->setCellValue('F' . $fila, $dato['estadoCivil']);
            $this->setCellValue('G' . $fila, $dato['sexo']);
            $this->setCellValue('H' . $fila, $dato['diaNacimiento']."-".$dato['mesNacimiento']."-".$dato['anoNacimiento']);
            $this->setCellValue('I' . $fila, $dato['edadPersonal']);
            $this->setCellValue('J' . $fila, $dato['cargo']);
            $this->setCellValue('K' . $fila, $dato['estatus']);
            $this->setCellValue('L' . $fila, $dato['nivelAcademico']);
            $this->setCellValue('M' . $fila, $dato['telefono']);
            $this->setCellValue('N' . $fila, $dato['fechaCreada']);
            $this->setCellValue('O' . $fila, $dato['dependencia']);
            $this->setCellValue('P' . $fila, $dato['departamento']);



            // Aplicar estilos a la fila
            $columnas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P'];
            foreach ($columnas as $columna) {
                $this->setCellStyle($columna . $fila, $bgColor, $textColor, 11);
                $this->setCellAlignment($columna . $fila, Alignment::HORIZONTAL_CENTER); //Centrar los datos
            }

            $fila++;
            $colorAlternado = !$colorAlternado; // Cambiar el color para la siguiente fila
        }
        // Aplicar bordes a toda la tabla
        $this->setBorders('A1:P' . ($fila - 1), 'FF5DADE2'); // Bordes de A1 hasta la última fila

        $writer = new Xlsx($this->spreadsheet);
        // $writer->save($this->filename);

        //Devolver el archivo para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. basename($this->filename).'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //FILTAR POR VIVIENDA
    public function generarExcelvivienda(string $vivienda){
        // Generar el array de datos directamente en PHP
        $datos = $this->personalModel->getDatosEmpleadoFiltro('ubi.vivienda = ?',[$vivienda]);


        // Combinar celdas y centrar el título
        $this->mergeCells('A1:P1'); // Combinar de A1 a E1
        $this->setCellValue('A1', 'ATLAS');
        $this->setCellStyle('A1', 'FF1929BB', 'FFFFFFFF', 12, true); // Estilos para ATLAS
        $this->setCellAlignment('A1', Alignment::HORIZONTAL_CENTER); // Centrar el texto

        // Establecer las cabeceras de la tabla
        $this->setCellValue('A2', 'Primer Nombre');
        $this->setCellValue('B2', 'Segundo Nombre');
        $this->setCellValue('C2', 'Primer Apellido');
        $this->setCellValue('D2', 'Segundo Nombre');
        $this->setCellValue('E2', 'Cédula');
        $this->setCellValue('F2', 'Estado Civil');
        $this->setCellValue('G2', 'Sexualidad');
        $this->setCellValue('H2', 'Fecha De N.');
        $this->setCellValue('I2', 'Edad');
        $this->setCellValue('J2', 'Estatus');
        $this->setCellValue('K2', 'Cargo');
        $this->setCellValue('L2', 'Nivel Academico');
        $this->setCellValue('M2', 'Telefono Personal');
        $this->setCellValue('N2', 'Fecha De ING');
        $this->setCellValue('O2', 'Dependencia');
        $this->setCellValue('P2', 'Departamento');


        // Estilos para las cabeceras
        $cabeceras = ['A2', 'B2', 'C2', 'D2', 'E2', 'F2', 'G2', 'H2', 'I2', 'J2', 'K2', 'L2', 'M2', 'N2', 'O2', 'P2'];
        foreach ($cabeceras as $cabecera) {
            $this->setCellStyle($cabecera, 'FF1929BB', 'FFFFFFFF', 12,true);
            $this->setCellAlignment($cabecera, Alignment::HORIZONTAL_CENTER); // Centrar cabeceras
        }

        // Ajustar el ancho de las columnas
        $this->setColumnWidth('A', 20);
        $this->setColumnWidth('B', 20);
        $this->setColumnWidth('C', 20);
        $this->setColumnWidth('D', 20);
        $this->setColumnWidth('E', 20);
        $this->setColumnWidth('F', 20);
        $this->setColumnWidth('G', 20);
        $this->setColumnWidth('H', 20);
        $this->setColumnWidth('I', 10);
        $this->setColumnWidth('J', 30);
        $this->setColumnWidth('K', 30);
        $this->setColumnWidth('L', 30);
        $this->setColumnWidth('M', 30);
        $this->setColumnWidth('N', 20);
        $this->setColumnWidth('O', 60);
        $this->setColumnWidth('P', 60);


        // Imprimir los datos del array con colores alternados
        $fila = 3; // Comenzar en la fila 3
        $colorAlternado = true; // Iniciar con el primer color
        foreach ($datos as $dato) {
            $bgColor = $colorAlternado ? 'FFD6EAF8' : 'FFFFFFFF'; // Color alternado
            $textColor = 'FF000000'; // Color de texto negro

            $this->setCellValue('A' . $fila, $dato['primerNombre']);
            $this->setCellValue('B' . $fila, $dato['segundoNombre']);
            $this->setCellValue('C' . $fila, $dato['primerApellido']);
            $this->setCellValue('D' . $fila, $dato['segundoApellido']);
            $this->setCellValue('E' . $fila, $dato['cedula']);
            $this->setCellValue('F' . $fila, $dato['estadoCivil']);
            $this->setCellValue('G' . $fila, $dato['sexo']);
            $this->setCellValue('H' . $fila, $dato['diaNacimiento']."-".$dato['mesNacimiento']."-".$dato['anoNacimiento']);
            $this->setCellValue('I' . $fila, $dato['edadPersonal']);
            $this->setCellValue('J' . $fila, $dato['cargo']);
            $this->setCellValue('K' . $fila, $dato['estatus']);
            $this->setCellValue('L' . $fila, $dato['nivelAcademico']);
            $this->setCellValue('M' . $fila, $dato['telefono']);
            $this->setCellValue('N' . $fila, $dato['fechaCreada']);
            $this->setCellValue('O' . $fila, $dato['dependencia']);
            $this->setCellValue('P' . $fila, $dato['departamento']);



            // Aplicar estilos a la fila
            $columnas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P'];
            foreach ($columnas as $columna) {
                $this->setCellStyle($columna . $fila, $bgColor, $textColor, 11);
                $this->setCellAlignment($columna . $fila, Alignment::HORIZONTAL_CENTER); //Centrar los datos
            }

            $fila++;
            $colorAlternado = !$colorAlternado; // Cambiar el color para la siguiente fila
        }
        // Aplicar bordes a toda la tabla
        $this->setBorders('A1:P' . ($fila - 1), 'FF5DADE2'); // Bordes de A1 hasta la última fila

        $writer = new Xlsx($this->spreadsheet);
        // $writer->save($this->filename);

        //Devolver el archivo para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. basename($this->filename).'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //FILTAR POR NIVEL ACADEMICO
    public function generarExcelnivelAcademico(string $nivelAcademico){
        // Generar el array de datos directamente en PHP
        $datos = $this->personalModel->getDatosEmpleadoFiltro('de.nivelAcademico = ?',[$nivelAcademico]);


        // Combinar celdas y centrar el título
        $this->mergeCells('A1:P1'); // Combinar de A1 a E1
        $this->setCellValue('A1', 'ATLAS');
        $this->setCellStyle('A1', 'FF1929BB', 'FFFFFFFF', 12, true); // Estilos para ATLAS
        $this->setCellAlignment('A1', Alignment::HORIZONTAL_CENTER); // Centrar el texto

        // Establecer las cabeceras de la tabla
        $this->setCellValue('A2', 'Primer Nombre');
        $this->setCellValue('B2', 'Segundo Nombre');
        $this->setCellValue('C2', 'Primer Apellido');
        $this->setCellValue('D2', 'Segundo Nombre');
        $this->setCellValue('E2', 'Cédula');
        $this->setCellValue('F2', 'Estado Civil');
        $this->setCellValue('G2', 'Sexualidad');
        $this->setCellValue('H2', 'Fecha De N.');
        $this->setCellValue('I2', 'Edad');
        $this->setCellValue('J2', 'Estatus');
        $this->setCellValue('K2', 'Cargo');
        $this->setCellValue('L2', 'Nivel Academico');
        $this->setCellValue('M2', 'Telefono Personal');
        $this->setCellValue('N2', 'Fecha De ING');
        $this->setCellValue('O2', 'Dependencia');
        $this->setCellValue('P2', 'Departamento');


        // Estilos para las cabeceras
        $cabeceras = ['A2', 'B2', 'C2', 'D2', 'E2', 'F2', 'G2', 'H2', 'I2', 'J2', 'K2', 'L2', 'M2', 'N2', 'O2', 'P2'];
        foreach ($cabeceras as $cabecera) {
            $this->setCellStyle($cabecera, 'FF1929BB', 'FFFFFFFF', 12,true);
            $this->setCellAlignment($cabecera, Alignment::HORIZONTAL_CENTER); // Centrar cabeceras
        }

        // Ajustar el ancho de las columnas
        $this->setColumnWidth('A', 20);
        $this->setColumnWidth('B', 20);
        $this->setColumnWidth('C', 20);
        $this->setColumnWidth('D', 20);
        $this->setColumnWidth('E', 20);
        $this->setColumnWidth('F', 20);
        $this->setColumnWidth('G', 20);
        $this->setColumnWidth('H', 20);
        $this->setColumnWidth('I', 10);
        $this->setColumnWidth('J', 30);
        $this->setColumnWidth('K', 30);
        $this->setColumnWidth('L', 30);
        $this->setColumnWidth('M', 30);
        $this->setColumnWidth('N', 20);
        $this->setColumnWidth('O', 60);
        $this->setColumnWidth('P', 60);


        // Imprimir los datos del array con colores alternados
        $fila = 3; // Comenzar en la fila 3
        $colorAlternado = true; // Iniciar con el primer color
        foreach ($datos as $dato) {
            $bgColor = $colorAlternado ? 'FFD6EAF8' : 'FFFFFFFF'; // Color alternado
            $textColor = 'FF000000'; // Color de texto negro

            $this->setCellValue('A' . $fila, $dato['primerNombre']);
            $this->setCellValue('B' . $fila, $dato['segundoNombre']);
            $this->setCellValue('C' . $fila, $dato['primerApellido']);
            $this->setCellValue('D' . $fila, $dato['segundoApellido']);
            $this->setCellValue('E' . $fila, $dato['cedula']);
            $this->setCellValue('F' . $fila, $dato['estadoCivil']);
            $this->setCellValue('G' . $fila, $dato['sexo']);
            $this->setCellValue('H' . $fila, $dato['diaNacimiento']."-".$dato['mesNacimiento']."-".$dato['anoNacimiento']);
            $this->setCellValue('I' . $fila, $dato['edadPersonal']);
            $this->setCellValue('J' . $fila, $dato['cargo']);
            $this->setCellValue('K' . $fila, $dato['estatus']);
            $this->setCellValue('L' . $fila, $dato['nivelAcademico']);
            $this->setCellValue('M' . $fila, $dato['telefono']);
            $this->setCellValue('N' . $fila, $dato['fechaCreada']);
            $this->setCellValue('O' . $fila, $dato['dependencia']);
            $this->setCellValue('P' . $fila, $dato['departamento']);



            // Aplicar estilos a la fila
            $columnas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P'];
            foreach ($columnas as $columna) {
                $this->setCellStyle($columna . $fila, $bgColor, $textColor, 11);
                $this->setCellAlignment($columna . $fila, Alignment::HORIZONTAL_CENTER); //Centrar los datos
            }

            $fila++;
            $colorAlternado = !$colorAlternado; // Cambiar el color para la siguiente fila
        }
        // Aplicar bordes a toda la tabla
        $this->setBorders('A1:P' . ($fila - 1), 'FF5DADE2'); // Bordes de A1 hasta la última fila

        $writer = new Xlsx($this->spreadsheet);
        // $writer->save($this->filename);

        //Devolver el archivo para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. basename($this->filename).'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


    //FILTAR POR DIRECCION
    public function generarExceldireccion(string $estado, string $municipio, $parroquia){
        // Generar el array de datos directamente en PHP
        $datos = $this->personalModel->getDatosEmpleadoFiltro('ubi.idEstado = ? AND ubi.idMunicipio  = ? AND ubi.idParroquia  = ?',[$estado, $municipio, $parroquia]);


        // Combinar celdas y centrar el título
        $this->mergeCells('A1:P1'); // Combinar de A1 a E1
        $this->setCellValue('A1', 'ATLAS');
        $this->setCellStyle('A1', 'FF1929BB', 'FFFFFFFF', 12, true); // Estilos para ATLAS
        $this->setCellAlignment('A1', Alignment::HORIZONTAL_CENTER); // Centrar el texto

        // Establecer las cabeceras de la tabla
        $this->setCellValue('A2', 'Primer Nombre');
        $this->setCellValue('B2', 'Segundo Nombre');
        $this->setCellValue('C2', 'Primer Apellido');
        $this->setCellValue('D2', 'Segundo Nombre');
        $this->setCellValue('E2', 'Cédula');
        $this->setCellValue('F2', 'Estado Civil');
        $this->setCellValue('G2', 'Sexualidad');
        $this->setCellValue('H2', 'Fecha De N.');
        $this->setCellValue('I2', 'Edad');
        $this->setCellValue('J2', 'Estatus');
        $this->setCellValue('K2', 'Cargo');
        $this->setCellValue('L2', 'Nivel Academico');
        $this->setCellValue('M2', 'Telefono Personal');
        $this->setCellValue('N2', 'Fecha De ING');
        $this->setCellValue('O2', 'Dependencia');
        $this->setCellValue('P2', 'Departamento');


        // Estilos para las cabeceras
        $cabeceras = ['A2', 'B2', 'C2', 'D2', 'E2', 'F2', 'G2', 'H2', 'I2', 'J2', 'K2', 'L2', 'M2', 'N2', 'O2', 'P2'];
        foreach ($cabeceras as $cabecera) {
            $this->setCellStyle($cabecera, 'FF1929BB', 'FFFFFFFF', 12,true);
            $this->setCellAlignment($cabecera, Alignment::HORIZONTAL_CENTER); // Centrar cabeceras
        }

        // Ajustar el ancho de las columnas
        $this->setColumnWidth('A', 20);
        $this->setColumnWidth('B', 20);
        $this->setColumnWidth('C', 20);
        $this->setColumnWidth('D', 20);
        $this->setColumnWidth('E', 20);
        $this->setColumnWidth('F', 20);
        $this->setColumnWidth('G', 20);
        $this->setColumnWidth('H', 20);
        $this->setColumnWidth('I', 10);
        $this->setColumnWidth('J', 30);
        $this->setColumnWidth('K', 30);
        $this->setColumnWidth('L', 30);
        $this->setColumnWidth('M', 30);
        $this->setColumnWidth('N', 20);
        $this->setColumnWidth('O', 60);
        $this->setColumnWidth('P', 60);


        // Imprimir los datos del array con colores alternados
        $fila = 3; // Comenzar en la fila 3
        $colorAlternado = true; // Iniciar con el primer color
        foreach ($datos as $dato) {
            $bgColor = $colorAlternado ? 'FFD6EAF8' : 'FFFFFFFF'; // Color alternado
            $textColor = 'FF000000'; // Color de texto negro

            $this->setCellValue('A' . $fila, $dato['primerNombre']);
            $this->setCellValue('B' . $fila, $dato['segundoNombre']);
            $this->setCellValue('C' . $fila, $dato['primerApellido']);
            $this->setCellValue('D' . $fila, $dato['segundoApellido']);
            $this->setCellValue('E' . $fila, $dato['cedula']);
            $this->setCellValue('F' . $fila, $dato['estadoCivil']);
            $this->setCellValue('G' . $fila, $dato['sexo']);
            $this->setCellValue('H' . $fila, $dato['diaNacimiento']."-".$dato['mesNacimiento']."-".$dato['anoNacimiento']);
            $this->setCellValue('I' . $fila, $dato['edadPersonal']);
            $this->setCellValue('J' . $fila, $dato['cargo']);
            $this->setCellValue('K' . $fila, $dato['estatus']);
            $this->setCellValue('L' . $fila, $dato['nivelAcademico']);
            $this->setCellValue('M' . $fila, $dato['telefono']);
            $this->setCellValue('N' . $fila, $dato['fechaCreada']);
            $this->setCellValue('O' . $fila, $dato['dependencia']);
            $this->setCellValue('P' . $fila, $dato['departamento']);



            // Aplicar estilos a la fila
            $columnas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P'];
            foreach ($columnas as $columna) {
                $this->setCellStyle($columna . $fila, $bgColor, $textColor, 11);
                $this->setCellAlignment($columna . $fila, Alignment::HORIZONTAL_CENTER); //Centrar los datos
            }

            $fila++;
            $colorAlternado = !$colorAlternado; // Cambiar el color para la siguiente fila
        }
        // Aplicar bordes a toda la tabla
        $this->setBorders('A1:P' . ($fila - 1), 'FF5DADE2'); // Bordes de A1 hasta la última fila

        $writer = new Xlsx($this->spreadsheet);
        // $writer->save($this->filename);

        //Devolver el archivo para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. basename($this->filename).'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //FILTAR POR RANGO DE FLECHA
    public function generarExcelrangoFhecha(string $fecha_Ini, string $fecha_Fin, string $fecha_IniESPA, string $fecha_FinESPA){
        // Generar el array de datos directamente en PHP
        $datos = $this->personalModel->getDatosEmpleadoFiltro('de.fechaING BETWEEN ? AND ?',[$fecha_Ini, $fecha_Fin]);


        // Combinar celdas y centrar el título
        $this->mergeCells('A1:P1'); // Combinar de A1 a E1
        $this->setCellValue('A1', 'ATLAS');
        $this->setCellStyle('A1', 'FF1929BB', 'FFFFFFFF', 12, true); // Estilos para ATLAS
        $this->setCellAlignment('A1', Alignment::HORIZONTAL_CENTER); // Centrar el texto

        // Establecer las cabeceras de la tabla
        $this->setCellValue('A2', 'Primer Nombre');
        $this->setCellValue('B2', 'Segundo Nombre');
        $this->setCellValue('C2', 'Primer Apellido');
        $this->setCellValue('D2', 'Segundo Nombre');
        $this->setCellValue('E2', 'Cédula');
        $this->setCellValue('F2', 'Estado Civil');
        $this->setCellValue('G2', 'Sexualidad');
        $this->setCellValue('H2', 'Fecha De N.');
        $this->setCellValue('I2', 'Edad');
        $this->setCellValue('J2', 'Estatus');
        $this->setCellValue('K2', 'Cargo');
        $this->setCellValue('L2', 'Nivel Academico');
        $this->setCellValue('M2', 'Telefono Personal');
        $this->setCellValue('N2', 'Fecha De ING');
        $this->setCellValue('O2', 'Dependencia');
        $this->setCellValue('P2', 'Departamento');


        // Estilos para las cabeceras
        $cabeceras = ['A2', 'B2', 'C2', 'D2', 'E2', 'F2', 'G2', 'H2', 'I2', 'J2', 'K2', 'L2', 'M2', 'N2', 'O2', 'P2'];
        foreach ($cabeceras as $cabecera) {
            $this->setCellStyle($cabecera, 'FF1929BB', 'FFFFFFFF', 12,true);
            $this->setCellAlignment($cabecera, Alignment::HORIZONTAL_CENTER); // Centrar cabeceras
        }

        // Ajustar el ancho de las columnas
        $this->setColumnWidth('A', 20);
        $this->setColumnWidth('B', 20);
        $this->setColumnWidth('C', 20);
        $this->setColumnWidth('D', 20);
        $this->setColumnWidth('E', 20);
        $this->setColumnWidth('F', 20);
        $this->setColumnWidth('G', 20);
        $this->setColumnWidth('H', 20);
        $this->setColumnWidth('I', 10);
        $this->setColumnWidth('J', 30);
        $this->setColumnWidth('K', 30);
        $this->setColumnWidth('L', 30);
        $this->setColumnWidth('M', 30);
        $this->setColumnWidth('N', 20);
        $this->setColumnWidth('O', 60);
        $this->setColumnWidth('P', 60);


        // Imprimir los datos del array con colores alternados
        $fila = 3; // Comenzar en la fila 3
        $colorAlternado = true; // Iniciar con el primer color
        foreach ($datos as $dato) {
            $bgColor = $colorAlternado ? 'FFD6EAF8' : 'FFFFFFFF'; // Color alternado
            $textColor = 'FF000000'; // Color de texto negro

            $this->setCellValue('A' . $fila, $dato['primerNombre']);
            $this->setCellValue('B' . $fila, $dato['segundoNombre']);
            $this->setCellValue('C' . $fila, $dato['primerApellido']);
            $this->setCellValue('D' . $fila, $dato['segundoApellido']);
            $this->setCellValue('E' . $fila, $dato['cedula']);
            $this->setCellValue('F' . $fila, $dato['estadoCivil']);
            $this->setCellValue('G' . $fila, $dato['sexo']);
            $this->setCellValue('H' . $fila, $dato['diaNacimiento']."-".$dato['mesNacimiento']."-".$dato['anoNacimiento']);
            $this->setCellValue('I' . $fila, $dato['edadPersonal']);
            $this->setCellValue('J' . $fila, $dato['cargo']);
            $this->setCellValue('K' . $fila, $dato['estatus']);
            $this->setCellValue('L' . $fila, $dato['nivelAcademico']);
            $this->setCellValue('M' . $fila, $dato['telefono']);
            $this->setCellValue('N' . $fila, $dato['fechaCreada']);
            $this->setCellValue('O' . $fila, $dato['dependencia']);
            $this->setCellValue('P' . $fila, $dato['departamento']);



            // Aplicar estilos a la fila
            $columnas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P'];
            foreach ($columnas as $columna) {
                $this->setCellStyle($columna . $fila, $bgColor, $textColor, 11);
                $this->setCellAlignment($columna . $fila, Alignment::HORIZONTAL_CENTER); //Centrar los datos
            }

            $fila++;
            $colorAlternado = !$colorAlternado; // Cambiar el color para la siguiente fila
        }
        // Aplicar bordes a toda la tabla
        $this->setBorders('A1:P' . ($fila - 1), 'FF5DADE2'); // Bordes de A1 hasta la última fila

        $writer = new Xlsx($this->spreadsheet);
        // $writer->save($this->filename);

        //Devolver el archivo para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. basename($this->filename).'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //FILTAR POR DEPENDENCIA
    public function generarExceldependencia(string $dependencia){
        // Generar el array de datos directamente en PHP
        $datos = $this->personalModel->getDatosEmpleadoFiltro('de.idDependencia = ?',[$dependencia]);


        // Combinar celdas y centrar el título
        $this->mergeCells('A1:P1'); // Combinar de A1 a E1
        $this->setCellValue('A1', 'ATLAS');
        $this->setCellStyle('A1', 'FF1929BB', 'FFFFFFFF', 12, true); // Estilos para ATLAS
        $this->setCellAlignment('A1', Alignment::HORIZONTAL_CENTER); // Centrar el texto

        // Establecer las cabeceras de la tabla
        $this->setCellValue('A2', 'Primer Nombre');
        $this->setCellValue('B2', 'Segundo Nombre');
        $this->setCellValue('C2', 'Primer Apellido');
        $this->setCellValue('D2', 'Segundo Nombre');
        $this->setCellValue('E2', 'Cédula');
        $this->setCellValue('F2', 'Estado Civil');
        $this->setCellValue('G2', 'Sexualidad');
        $this->setCellValue('H2', 'Fecha De N.');
        $this->setCellValue('I2', 'Edad');
        $this->setCellValue('J2', 'Estatus');
        $this->setCellValue('K2', 'Cargo');
        $this->setCellValue('L2', 'Nivel Academico');
        $this->setCellValue('M2', 'Telefono Personal');
        $this->setCellValue('N2', 'Fecha De ING');
        $this->setCellValue('O2', 'Dependencia');
        $this->setCellValue('P2', 'Departamento');


        // Estilos para las cabeceras
        $cabeceras = ['A2', 'B2', 'C2', 'D2', 'E2', 'F2', 'G2', 'H2', 'I2', 'J2', 'K2', 'L2', 'M2', 'N2', 'O2', 'P2'];
        foreach ($cabeceras as $cabecera) {
            $this->setCellStyle($cabecera, 'FF1929BB', 'FFFFFFFF', 12,true);
            $this->setCellAlignment($cabecera, Alignment::HORIZONTAL_CENTER); // Centrar cabeceras
        }

        // Ajustar el ancho de las columnas
        $this->setColumnWidth('A', 20);
        $this->setColumnWidth('B', 20);
        $this->setColumnWidth('C', 20);
        $this->setColumnWidth('D', 20);
        $this->setColumnWidth('E', 20);
        $this->setColumnWidth('F', 20);
        $this->setColumnWidth('G', 20);
        $this->setColumnWidth('H', 20);
        $this->setColumnWidth('I', 10);
        $this->setColumnWidth('J', 30);
        $this->setColumnWidth('K', 30);
        $this->setColumnWidth('L', 30);
        $this->setColumnWidth('M', 30);
        $this->setColumnWidth('N', 20);
        $this->setColumnWidth('O', 60);
        $this->setColumnWidth('P', 60);


        // Imprimir los datos del array con colores alternados
        $fila = 3; // Comenzar en la fila 3
        $colorAlternado = true; // Iniciar con el primer color
        foreach ($datos as $dato) {
            $bgColor = $colorAlternado ? 'FFD6EAF8' : 'FFFFFFFF'; // Color alternado
            $textColor = 'FF000000'; // Color de texto negro

            $this->setCellValue('A' . $fila, $dato['primerNombre']);
            $this->setCellValue('B' . $fila, $dato['segundoNombre']);
            $this->setCellValue('C' . $fila, $dato['primerApellido']);
            $this->setCellValue('D' . $fila, $dato['segundoApellido']);
            $this->setCellValue('E' . $fila, $dato['cedula']);
            $this->setCellValue('F' . $fila, $dato['estadoCivil']);
            $this->setCellValue('G' . $fila, $dato['sexo']);
            $this->setCellValue('H' . $fila, $dato['diaNacimiento']."-".$dato['mesNacimiento']."-".$dato['anoNacimiento']);
            $this->setCellValue('I' . $fila, $dato['edadPersonal']);
            $this->setCellValue('J' . $fila, $dato['cargo']);
            $this->setCellValue('K' . $fila, $dato['estatus']);
            $this->setCellValue('L' . $fila, $dato['nivelAcademico']);
            $this->setCellValue('M' . $fila, $dato['telefono']);
            $this->setCellValue('N' . $fila, $dato['fechaCreada']);
            $this->setCellValue('O' . $fila, $dato['dependencia']);
            $this->setCellValue('P' . $fila, $dato['departamento']);



            // Aplicar estilos a la fila
            $columnas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P'];
            foreach ($columnas as $columna) {
                $this->setCellStyle($columna . $fila, $bgColor, $textColor, 11);
                $this->setCellAlignment($columna . $fila, Alignment::HORIZONTAL_CENTER); //Centrar los datos
            }

            $fila++;
            $colorAlternado = !$colorAlternado; // Cambiar el color para la siguiente fila
        }
        // Aplicar bordes a toda la tabla
        $this->setBorders('A1:P' . ($fila - 1), 'FF5DADE2'); // Bordes de A1 hasta la última fila

        $writer = new Xlsx($this->spreadsheet);
        // $writer->save($this->filename);

        //Devolver el archivo para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. basename($this->filename).'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    //FILTAR POR DEPARTAMENTO
    public function generarExceldepartamento(string $departamento){
        // Generar el array de datos directamente en PHP
        $datos = $this->personalModel->getDatosEmpleadoFiltro('de.idDepartamento = ?',[$departamento]);


        // Combinar celdas y centrar el título
        $this->mergeCells('A1:P1'); // Combinar de A1 a E1
        $this->setCellValue('A1', 'ATLAS');
        $this->setCellStyle('A1', 'FF1929BB', 'FFFFFFFF', 12, true); // Estilos para ATLAS
        $this->setCellAlignment('A1', Alignment::HORIZONTAL_CENTER); // Centrar el texto

        // Establecer las cabeceras de la tabla
        $this->setCellValue('A2', 'Primer Nombre');
        $this->setCellValue('B2', 'Segundo Nombre');
        $this->setCellValue('C2', 'Primer Apellido');
        $this->setCellValue('D2', 'Segundo Nombre');
        $this->setCellValue('E2', 'Cédula');
        $this->setCellValue('F2', 'Estado Civil');
        $this->setCellValue('G2', 'Sexualidad');
        $this->setCellValue('H2', 'Fecha De N.');
        $this->setCellValue('I2', 'Edad');
        $this->setCellValue('J2', 'Estatus');
        $this->setCellValue('K2', 'Cargo');
        $this->setCellValue('L2', 'Nivel Academico');
        $this->setCellValue('M2', 'Telefono Personal');
        $this->setCellValue('N2', 'Fecha De ING');
        $this->setCellValue('O2', 'Dependencia');
        $this->setCellValue('P2', 'Departamento');


        // Estilos para las cabeceras
        $cabeceras = ['A2', 'B2', 'C2', 'D2', 'E2', 'F2', 'G2', 'H2', 'I2', 'J2', 'K2', 'L2', 'M2', 'N2', 'O2', 'P2'];
        foreach ($cabeceras as $cabecera) {
            $this->setCellStyle($cabecera, 'FF1929BB', 'FFFFFFFF', 12,true);
            $this->setCellAlignment($cabecera, Alignment::HORIZONTAL_CENTER); // Centrar cabeceras
        }

        // Ajustar el ancho de las columnas
        $this->setColumnWidth('A', 20);
        $this->setColumnWidth('B', 20);
        $this->setColumnWidth('C', 20);
        $this->setColumnWidth('D', 20);
        $this->setColumnWidth('E', 20);
        $this->setColumnWidth('F', 20);
        $this->setColumnWidth('G', 20);
        $this->setColumnWidth('H', 20);
        $this->setColumnWidth('I', 10);
        $this->setColumnWidth('J', 30);
        $this->setColumnWidth('K', 30);
        $this->setColumnWidth('L', 30);
        $this->setColumnWidth('M', 30);
        $this->setColumnWidth('N', 20);
        $this->setColumnWidth('O', 60);
        $this->setColumnWidth('P', 60);


        // Imprimir los datos del array con colores alternados
        $fila = 3; // Comenzar en la fila 3
        $colorAlternado = true; // Iniciar con el primer color
        foreach ($datos as $dato) {
            $bgColor = $colorAlternado ? 'FFD6EAF8' : 'FFFFFFFF'; // Color alternado
            $textColor = 'FF000000'; // Color de texto negro

            $this->setCellValue('A' . $fila, $dato['primerNombre']);
            $this->setCellValue('B' . $fila, $dato['segundoNombre']);
            $this->setCellValue('C' . $fila, $dato['primerApellido']);
            $this->setCellValue('D' . $fila, $dato['segundoApellido']);
            $this->setCellValue('E' . $fila, $dato['cedula']);
            $this->setCellValue('F' . $fila, $dato['estadoCivil']);
            $this->setCellValue('G' . $fila, $dato['sexo']);
            $this->setCellValue('H' . $fila, $dato['diaNacimiento']."-".$dato['mesNacimiento']."-".$dato['anoNacimiento']);
            $this->setCellValue('I' . $fila, $dato['edadPersonal']);
            $this->setCellValue('J' . $fila, $dato['cargo']);
            $this->setCellValue('K' . $fila, $dato['estatus']);
            $this->setCellValue('L' . $fila, $dato['nivelAcademico']);
            $this->setCellValue('M' . $fila, $dato['telefono']);
            $this->setCellValue('N' . $fila, $dato['fechaCreada']);
            $this->setCellValue('O' . $fila, $dato['dependencia']);
            $this->setCellValue('P' . $fila, $dato['departamento']);



            // Aplicar estilos a la fila
            $columnas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P'];
            foreach ($columnas as $columna) {
                $this->setCellStyle($columna . $fila, $bgColor, $textColor, 11);
                $this->setCellAlignment($columna . $fila, Alignment::HORIZONTAL_CENTER); //Centrar los datos
            }

            $fila++;
            $colorAlternado = !$colorAlternado; // Cambiar el color para la siguiente fila
        }
        // Aplicar bordes a toda la tabla
        $this->setBorders('A1:P' . ($fila - 1), 'FF5DADE2'); // Bordes de A1 hasta la última fila

        $writer = new Xlsx($this->spreadsheet);
        // $writer->save($this->filename);

        //Devolver el archivo para descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. basename($this->filename).'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
?>