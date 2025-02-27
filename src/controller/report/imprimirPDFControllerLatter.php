<?php

namespace App\Atlas\controller\report;

use App\Atlas\models\dependenciasModel;
use App\Atlas\models\cargoModel;
use App\Atlas\models\estatusModel;
use App\Atlas\models\departamentoModel;
use App\Atlas\models\personalModel;
use App\Atlas\models\vacacionesModel;
use App\Atlas\controller\report\pdfController; // Importa la clase pdfController
use App\Atlas\controller\auditoriaController;
use App\Atlas\config\App;

date_default_timezone_set("America/Caracas");

class imprimirPDFControllerLatter
{
    private $dependenciasData;
    private $cargoData;
    private $estatusData;
    private $departamentoData;
    private $personalData;
    private $vacacionesData;
    private $pdf;

    private $app;
    private $auditoriaController;
    private $idUsuario;
    private $nombreUsuario;

    public function __construct($orientation = 'P', $unit = 'mm', $size = 'Letter')
    {
        $this->dependenciasData = new dependenciasModel();
        $this->pdf = new pdfController($orientation, $unit, $size); // Crear una instancia de pdfController con los parámetros
        $this->cargoData = new cargoModel();
        $this->estatusData = new estatusModel();
        $this->departamentoData = new departamentoModel();
        $this->personalData = new personalModel();
        $this->vacacionesData = new vacacionesModel();
        $this->app = new App();
        $this->auditoriaController = new auditoriaController();
        $this->app->iniciarSession();
        $this->idUsuario = $_SESSION['id'];
        $this->nombreUsuario = $_SESSION['usuario'];
    }

    public function generarDependenciaPDF()
    {
        $pdf = $this->pdf; // Obtener la instancia de pdfController
        $pdf->title = 'Reporte de Dependencias'; // Título del reporte
        // Definir los encabezados, los anchos y las alineaciones de columna
        $cabezaHeader = ['Nombre', 'Edad', 'Ciudad'];
        $column_widths = [105, 60, 30];
        $column_alignments = ['L', 'C', 'R'];
        $column_headerAlignments = ['L', 'C', 'R'];
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


        // Obtener los datos de dependencia
        $datosDependencia = $this->dependenciasData->getDatosDependencia();

        // Procesar los datos para asegurarse de que sean un array
        $datosImprimir = [];
        if (is_array($datosDependencia)) {
            foreach ($datosDependencia as $dato) {
                if (is_array($dato)) {
                    // auditoria
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de dependencia', 'El usuario'. $this->nombreUsuario. ' a descargado un pdf de las dependencias en tamaño carta formato vertical');
                    $datosImprimir[] = [
                        $dato['dependencia'] ?? '',
                        $dato['estado'] ?? '',
                        $dato['codigo'] ?? ''
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

    public function generarCargoPDF()
    {
        $pdf = $this->pdf; // Obtener la instancia de pdfController
        $pdf->title = 'Reporte de cargo'; // Título del reporte
        // Definir los encabezados, los anchos y las alineaciones de columna
        $cabezaHeader = ['N', 'Cargo'];
        $column_widths = [40, 100];
        $column_alignments = ['L', 'C'];
        $column_headerAlignments = ['L', 'C'];
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
        $datosCargo = $this->cargoData->getDatosCargo();

        // Procesar los datos para asegurarse de que sean un array
        $datosImprimir = [];
        if (is_array($datosCargo)) {
            foreach ($datosCargo as $dato) {
                if (is_array($dato)) {
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de cargo', 'El usuario'. $this->nombreUsuario. ' a descargado un pdf de los cargos en tamaño carta formato vertical');
                    $datosImprimir[] = [
                        $dato['id_cargo'] ?? '',
                        $dato['cargo'] ?? ''
                    ];
                }
            }
        }

        // Establecer los datos a imprimir
        $pdf->SetDatosImprimir($datosImprimir);

        // Agregar una página
        $pdf->AddPage();

        // Centrar la tabla en el medio de la página
        $pageWidth = $pdf->GetPageWidth();
        $tableWidth = array_sum($column_widths);
        $x = ($pageWidth - $tableWidth) / 2;
        $pdf->SetX($x);
        // Imprimir los datos
        $pdf->ImprimirDatos();

        // Salida del PDF
        $pdf->Output('I', 'reporte.pdf');
    }

    public function generarEstatusPDF() {
        $pdf = $this->pdf; // Obtener la instancia de pdfController
        $pdf->title = 'Reporte de estatus'; // Título del reporte
        // Definir los encabezados, los anchos y las alineaciones de columna
        $cabezaHeader = ['N', 'Estatus'];
        $column_widths = [40, 100];
        $column_alignments = ['L', 'C'];
        $column_headerAlignments = ['L', 'C'];
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
        $datosCargo = $this->estatusData->getDatosEstatus();

        // Procesar los datos para asegurarse de que sean un array
        $datosImprimir = [];
        if (is_array($datosCargo)) {
            foreach ($datosCargo as $dato) {
                if (is_array($dato)) {
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de estatus', 'El usuario'. $this->nombreUsuario. ' a descargado un pdf de los estatus en tamaño carta formato vertical');

                    $datosImprimir[] = [
                        $dato['id_estatus'] ?? '',
                        $dato['estatus'] ?? ''
                    ];
                }
            }
        }

        // Establecer los datos a imprimir
        $pdf->SetDatosImprimir($datosImprimir);

        // Agregar una página
        $pdf->AddPage();

        // Centrar la tabla en el medio de la página
        $pageWidth = $pdf->GetPageWidth();
        $tableWidth = array_sum($column_widths);
        $x = ($pageWidth - $tableWidth) / 2;
        $pdf->SetX($x);
        // Imprimir los datos
        $pdf->ImprimirDatos();

        // Salida del PDF
        $pdf->Output('I', 'reporte.pdf');
    }

    public function generarDepartamentoPDF() {
        $pdf = $this->pdf; // Obtener la instancia de pdfController
        $pdf->title = 'Reporte de departamento'; // Título del reporte
        // Definir los encabezados, los anchos y las alineaciones de columna
        $cabezaHeader = ['N', 'Departamento'];
        $column_widths = [40, 100];
        $column_alignments = ['L', 'C'];
        $column_headerAlignments = ['L', 'C'];
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
        $datosCargo = $this->departamentoData->getDatosDepartamento();

        // Procesar los datos para asegurarse de que sean un array
        $datosImprimir = [];
        if (is_array($datosCargo)) {
            foreach ($datosCargo as $dato) {
                if (is_array($dato)) {
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de departamento', 'El usuario'. $this->nombreUsuario. ' a descargado un pdf de los departamento en tamaño carta formato vertical');

                    $datosImprimir[] = [
                        $dato['id_departamento'] ?? '',
                        $dato['departamento'] ?? ''
                    ];
                }
            }
        }

        // Establecer los datos a imprimir
        $pdf->SetDatosImprimir($datosImprimir);

        // Agregar una página
        $pdf->AddPage();

        // Centrar la tabla en el medio de la página
        $pageWidth = $pdf->GetPageWidth();
        $tableWidth = array_sum($column_widths);
        $x = ($pageWidth - $tableWidth) / 2;
        $pdf->SetX($x);
        // Imprimir los datos
        $pdf->ImprimirDatos();

        // Salida del PDF
        $pdf->Output('I', 'reporte.pdf');
    }

    public function generarAusenciasPDF(){
        $pdf = $this->pdf; // Obtener la instancia de pdfController
        $pdf->title = 'Reporte de ausencias'; // Título del reporte
        // Definir los encabezados, los anchos y las alineaciones de columna
        $cabezaHeader = ['N', 'Nombre', 'Cedula', 'Permiso', 'Fecha Inicio', 'Fecha Final', 'estado'];
        $column_widths = [10, 50, 20 ,20, 30, 30, 30];
        $column_alignments = ['L', 'C'];
        $column_headerAlignments = ['L', 'C'];
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
        $datosCargo = $this->vacacionesData->getTotalDatosAusencia();
        $i = 0;
        // Procesar los datos para asegurarse de que sean un array
        $datosImprimir = [];
        if (is_array($datosCargo)) {
            foreach ($datosCargo as $dato) {
                if (is_array($dato)) {
                    $activo = $dato['estado'] == 1 ? 'Sin liberar' : 'Liberado';
                    $i++;
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de ausencia', 'El usuario'. $this->nombreUsuario. ' a descargado un pdf de los cargos en tamaño carta formato vertical');
                    $datosImprimir[] = [
                        $i ?? '',
                        $dato['primerNombre']." ".$dato['primerApellido'] ?? '',
                        $dato['cedula'] ?? '',
                        $dato['idPermiso'] ?? '',
                        $dato['fechaInicio'] ?? '',
                        $dato['fechaFinal'] ?? '',
                        $activo ?? ''

                    ];
                }
            }
        }

        // Establecer los datos a imprimir
        $pdf->SetDatosImprimir($datosImprimir);

        // Agregar una página
        $pdf->AddPage();

        // Centrar la tabla en el medio de la página
        $pageWidth = $pdf->GetPageWidth();
        $tableWidth = array_sum($column_widths);
        $x = ($pageWidth - $tableWidth) / 2;
        $pdf->SetX($x);
        // Imprimir los datos
        $pdf->ImprimirDatos();

        // Salida del PDF
        $pdf->Output('I', 'reporte.pdf');
    }
}
