<?php

namespace App\Atlas\controller\report;

use App\Atlas\models\dependenciasModel;
use App\Atlas\models\cargoModel;
use App\Atlas\models\estatusModel;
use App\Atlas\models\departamentoModel;
use App\Atlas\models\personalModel;
use App\Atlas\controller\report\pdfControllerL; // Importa la clase pdfController
use App\Atlas\controller\auditoriaController;
use App\Atlas\config\App;

use FPDF;
date_default_timezone_set("America/Caracas");

class imprimirPDFControllerLatterL
{
    private $dependenciasData;
    private $cargoData;
    private $estatusData;
    private $departamentoData;
    private $personalData;
    private $pdf;

    private $app;
    private $auditoriaController;
    private $idUsuario;
    private $nombreUsuario;

    public function __construct($orientation = 'L', $unit = 'mm', $size = 'Letter')
    {
        $this->dependenciasData = new dependenciasModel();
        $this->pdf = new pdfControllerL($orientation, $unit, $size); // Crear una instancia de pdfController con los parámetros
        $this->cargoData = new cargoModel();
        $this->estatusData = new estatusModel();
        $this->departamentoData = new departamentoModel();
        $this->personalData = new personalModel();
        $this->app = new App();
        $this->auditoriaController = new auditoriaController();
        $this->app->iniciarSession();
        $this->idUsuario = $_SESSION['id'];
        $this->nombreUsuario = $_SESSION['usuario'];
    }

    public function generarEmpleadoPDF()
    {
        $pdf = $this->pdf; // Obtener la instancia de pdfController
        $pdf->title = 'Reporte de empleado'; // Título del reporte

        // Definir los encabezados, los anchos y las alineaciones de columna
        $cabezaHeader = ['Nº','Nombre', 'Apellido', 'Cédula', 'Cargo', 'Dependencia', 'Departamento', 'Estatus'];
        $column_widths = [10,20, 20, 26, 35, 84, 40, 30];
        $column_alignments = [];
        $column_headerAlignments = [];
        $pdf->SetHeaderData($cabezaHeader, $column_widths, $column_alignments, $column_headerAlignments);

        // Configurar la fuente y altura de las celdas
        $header_font = 'Arial'; // Fuente del encabezado
        $header_font_size = 11; // Tamaño de la fuente del encabezado
        $header_font_style = 'B'; // Estilo de la fuente del encabezado (B = negrita)
        $data_font = 'Arial'; // Fuente de los datos
        $data_font_size = 10; // Tamaño de la fuente de los datos
        $data_font_style = ''; // Estilo de la fuente de los datos ('' = normal)
        $header_height = 9; // Altura de las celdas del encabezado
        $data_height = 8; // Altura de las celdas de los datos

        $pdf->SetFontConfig($header_font, $header_font_size, $header_font_style, $data_font, $data_font_size, $data_font_style, $header_height, $data_height);

        // Obtener los datos de Cargo

        $datosEmpleado = $this->personalData->getTotalDatosEmpleado();

        // Procesar los datos para asegurarse de que sean un array
        $datosImprimir = [];
        $i = 0;
         $pdf->personalContar = 0;
        if (is_array($datosEmpleado)) {
            foreach ($datosEmpleado as $dato) {
                if (is_array($dato)) {
                    // echo '<pre>';
                    // print_r($dato);
                    // echo '</pre>';
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de empleado', 'El usuario'. $this->nombreUsuario. ' a descargado un pdf de los empelados en tamaño carta formato vertical');

                    $i++;
                    $pdf->personalContar++;
                    $datosImprimir[] = [
                        $i,
                        $dato['primerNombre'] ?? '',
                        $dato['primerApellido'] ?? '',
                        $dato['cedula'] ?? '',
                        $dato['cargo'] ?? '',
                        $dato['dependencia'] ?? '',
                        $dato['departamento'] ?? '',
                        $dato['estatus'] ?? ''
                    ];
                }
            }
        }

        // Establecer los datos a imprimir
        $pdf->SetDatosImprimir($datosImprimir);

        // Agregar una página
        $pdf->AddPage();

        // Imprimir los datos
        $pdf->ImprimirDatos();

        // Salida del PDF
        $pdf->Output('I', 'reporte.pdf');
    }

    public function generarFamiliarPDF()
    {
        $pdf = $this->pdf; // Obtener la instancia de pdfController
        $pdf->title = 'Reporte de familiar'; // Título del reporte

        // Definir los encabezados, los anchos y las alineaciones de columna
        $cabezaHeader = ['Nº','Empleado', 'Nombre', 'Apellido', 'Cédula', 'Tomo', 'Folio', 'Parentesco','Discapacidad'];
        $column_widths = [10,30, 30, 30, 35, 25, 25, 35, 40];
        $column_alignments = [];
        $column_headerAlignments = [];
        $pdf->SetHeaderData($cabezaHeader, $column_widths, $column_alignments, $column_headerAlignments);

        // Configurar la fuente y altura de las celdas
        $header_font = 'Arial'; // Fuente del encabezado
        $header_font_size = 11; // Tamaño de la fuente del encabezado
        $header_font_style = 'B'; // Estilo de la fuente del encabezado (B = negrita)
        $data_font = 'Arial'; // Fuente de los datos
        $data_font_size = 10; // Tamaño de la fuente de los datos
        $data_font_style = ''; // Estilo de la fuente de los datos ('' = normal)
        $header_height = 9; // Altura de las celdas del encabezado
        $data_height = 8; // Altura de las celdas de los datos

        $pdf->SetFontConfig($header_font, $header_font_size, $header_font_style, $data_font, $data_font_size, $data_font_style, $header_height, $data_height);

        // Obtener los datos de Cargo

        $datosEmpleado = $this->personalData->getTotalDatosFamiliar();

        // Procesar los datos para asegurarse de que sean un array
        $datosImprimir = [];
        $i = 0;
         $pdf->personalContar = 0;
        if (is_array($datosEmpleado)) {
            foreach ($datosEmpleado as $dato) {
                if (is_array($dato)) {
                    // echo '<pre>';
                    // print_r($dato);
                    // echo '</pre>';
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de empleado', 'El usuario'. $this->nombreUsuario. ' a descargado un pdf de los empelados en tamaño carta formato vertical');
                    $discapacidad = $dato['discapacidad'];
                    if (empty($discapacidad)) {
                        $discapacidad = 'Sin Discapacidad';
                    }
                    $i++;
                    $pdf->personalContar++;
                    $datosImprimir[] = [
                        $i,
                        $dato['primerNombreEmpleado']." ".$dato['primerApellidoEmpleado'] ?? '',
                        $dato['primerNombreFamiliar'] ?? '',
                        $dato['primerApellidoFamiliar'] ?? '',
                        $dato['cedulaFamiliar'] ?? '',
                        $dato['tomo'] ?? '',
                        $dato['folio'] ?? '',
                        $dato['parentesco'] ?? '',
                        $discapacidad
                    ];
                }
            }
        }

        // Establecer los datos a imprimir
        $pdf->SetDatosImprimir($datosImprimir);

        // Agregar una página
        $pdf->AddPage();

        // Imprimir los datos
        $pdf->ImprimirDatos();

        // Salida del PDF
        $pdf->Output('I', 'reporte.pdf');
    }



}
