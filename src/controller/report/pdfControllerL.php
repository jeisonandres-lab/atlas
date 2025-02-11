<?php

namespace App\Atlas\controller\report;

use FPDF;

class pdfControllerL extends FPDF
{
    public $cabezaHeader;
    public $column_widths;
    public $column_alignments;
    public $column_headerAlignments;
    public $datosImprimir;
    public $header_height;
    public $data_height;
    public $header_font;
    public $header_font_size;
    public $header_font_style;
    public $data_font;
    public $data_font_size;
    public $data_font_style;
    public $title;
    public $page_size;
    public $personalContar;

    function __construct($orientation = 'L', $unit = 'mm', $size = '')
    {
        parent::__construct($orientation, $unit, $size);
        $this->cabezaHeader = []; // Inicializa el array de encabezado
        $this->column_widths = []; // Inicializa el array de anchos de columna
        $this->column_alignments = []; // Inicializa el array de alineaciones de columna
        $this->column_headerAlignments = []; // Inicializa el array de alineaciones de encabezado
        $this->datosImprimir = []; // Inicializa el array de datos a imprimir
        $this->header_height = 10; // Altura de las celdas del encabezado
        $this->data_height = 10; // Altura de las celdas de los datos
        $this->header_font = 'Arial'; // Fuente del encabezado
        $this->header_font_size = 11; // Tamaño de la fuente del encabezado
        $this->header_font_style = 'B'; // Estilo de la fuente del encabezado (B = negrita)
        $this->data_font = 'Arial'; // Fuente de los datos
        $this->data_font_size = 10; // Tamaño de la fuente de los datos
        $this->data_font_style = ''; // Estilo de la fuente de los datos ('' = normal)
        $this->title = 'Reporte'; // Título del reporte
        $this->page_size = $size; // Almacena el tamaño de la página
        $this->personalContar;
        $this->AliasNbPages(); // Define el alias {nb}
    }


    private function centrarTabla()
    {
        $pageWidth = $this->GetPageWidth();
        $tableWidth = array_sum($this->column_widths);
        $x = ($pageWidth - $tableWidth) / 2;
        $this->SetX($x);
    }

    function Header()
    {
        // Logo o imagen de cabecera (izquierda)
        $this->Image('../assets/img/images/inces.png', 10, 2, 30);

        // Logo o imagen de cabecera (derecha) - Ajusta la posición según necesites
        $this->Image('../assets/img/images/tuerca.png', 230, 0, 50);

        if ($this->personalContar == '') {
        }else{
            $this->SetY(20); // Posición desde el final
            $this->SetX(10); // Posición desde el final
            // Título principal
            $this->SetFont('Arial', 'B', 10);
            $this->SetFillColor(25, 41, 187); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(30, 7, 'Total Empleado', 1, 0, 'l', true);

            $this->SetFillColor(255, 255, 255); // Azul
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(15, 7, $this->personalContar, 1, 0, 'l', true);

            $this->Ln(12);
        }

        $this->SetY(17); // Posición desde el final
        $this->SetX(75); // Posición desde el final
        // Título principal
        $this->SetFont('Arial', 'B', 16);
        $this->SetFillColor(25, 41, 187); // Azul
        $this->SetTextColor(255, 255, 255); // Blanco
        $this->Cell(120, 12, $this->title, 1, 0, 'C', true);
        $this->Ln(12);

        // Cabeceras de columna (dinámicas)
        $this->SetFont($this->header_font, $this->header_font_style, $this->header_font_size);
        $this->SetFillColor(13, 113, 237); // Azul
        $this->SetTextColor(255, 255, 255); // Blanco



        foreach ($this->cabezaHeader as $i => $column) {
            $alignment = isset($this->column_headerAlignments[$i]) ? $this->column_headerAlignments[$i] : 'C';
            $this->Cell($this->column_widths[$i], $this->header_height, utf8_decode(ucfirst($column)), 1, 0, $alignment, true);
        }
        $this->Ln();
    }

    function Footer()
    {
        $this->SetY(-31); // Posición desde el final
        $this->SetX(8.5); // Posición desde el final

        // Número de página y fecha/hora
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 15, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'L');
        $fechaHora = date('d-m-Y h:i:s a');
        $this->Cell(0, 15, $fechaHora, 0, 0, 'R');

        // Ajustar la posición Y de la imagen según el tamaño de la página
        if ($this->page_size === 'Letter') {
            $atlas_position_y = -21;
            $atlas_position_x = 10;
            $logo_position_y = 195;
            $logo_position_x = 3;
        } else {
            $atlas_position_y = -22.5;
            $atlas_position_x = 10;
            $logo_position_y = 188;
            $logo_position_x = 3;
        }
        $this->SetXY($atlas_position_x, $atlas_position_y);
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(25, 41, 187); // Azul
        $this->Cell(0, 8, 'ATLAS', 0, 0, 'L');
        $this->Image('../assets/img/icons/dasdad-transformed-removebg.png', $logo_position_x, $logo_position_y, 6);
        $this->Ln(10);

        // Imagen de pie de página (ancho completo)
        $image_position_letter_y = 77;
        $image_position_letter_x = 0;

        // Imagen de pie de página (ancho completo)
        $image_position_a4_y = 62.5;
        $image_position_a4_x = 0;

        // Ajustar la posición Y de la imagen según el tamaño de la página
        if ($this->page_size === 'Letter') {
            $this->Image('../assets/img/images/pie.png',  $image_position_letter_x, $image_position_letter_y, $this->w);
        } else {
            $this->Image('../assets/img/images/pie.png', $image_position_a4_x, $image_position_a4_y, $this->w);
        }
    }

    // Método para definir el encabezado, los anchos y las alineaciones de columna
    public function SetHeaderData($cabezaHeader, $column_widths, $column_alignments, $column_headerAlignments)
    {
        $this->cabezaHeader = $cabezaHeader;
        $this->column_widths = $column_widths;
        $this->column_alignments = $column_alignments;
        $this->column_headerAlignments = $column_headerAlignments;
    }

    // Método para definir los datos a imprimir
    public function SetDatosImprimir($datosImprimir)
    {
        $this->datosImprimir = $datosImprimir;
    }

    // Método para definir la configuración de la fuente y altura de las celdas
    public function SetFontConfig($header_font, $header_font_size, $header_font_style, $data_font, $data_font_size, $data_font_style, $header_height, $data_height)
    {
        $this->header_font = $header_font;
        $this->header_font_size = $header_font_size;
        $this->header_font_style = $header_font_style;
        $this->data_font = $data_font;
        $this->data_font_size = $data_font_size;
        $this->data_font_style = $data_font_style;
        $this->header_height = $header_height;
        $this->data_height = $data_height;
    }

    public function getTitle($title)
    {
        $this->title = $title;
    }

    // Método para imprimir los datos
    // Método para imprimir los datos
    public function ImprimirDatos()
    {
        $this->SetFont($this->data_font, $this->data_font_style, $this->data_font_size);
        $this->SetTextColor(0, 0, 0); // Negro

        if (is_array($this->datosImprimir)) {
            foreach ($this->datosImprimir as $fila) {
                if (is_array($fila)) {
                    // Centrar la tabla


                    foreach ($fila as $i => $dato) {
                        $alignment = isset($this->column_alignments[$i]) ? $this->column_alignments[$i] : 'C';
                        $this->Cell($this->column_widths[$i], $this->data_height, utf8_decode($dato), 1, 0, $alignment);
                    }
                    $this->Ln();
                }
            }
        }
    }
}
