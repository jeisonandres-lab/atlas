<?php

namespace App\Atlas\controller\report;

use App\Atlas\models\personalModel;
use App\Atlas\controller\auditoriaController;
use App\Atlas\config\App;

use FPDF; // Importa la clase pdfController

date_default_timezone_set("America/Caracas");

class reportesController extends FPDF
{
    private $personalData;
    private $app;
    private $auditoriaController;
    private $idUsuario;
    private $nombreUsuario;
    public $title = 'Empleado Filtrado'; // Título del reporte

    public function __construct($orientation = 'L', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
        $this->personalData = new personalModel();
        $this->AliasNbPages(); // Llamada crucial aquí, una sola vez
        $this->app = new App();
        $this->auditoriaController = new auditoriaController();
        $this->app->iniciarSession();
        $this->idUsuario = $_SESSION['id'];
        $this->nombreUsuario = $_SESSION['usuario'];
    }

    public function setTitulo(string $nuevoTitulo)
    {

        return $this->title = $nuevoTitulo;
    }

    function Header()
    {
        $this->Image('../assets/img/images/inces.png', 10, 2, 30);
        $this->Image('../assets/img/images/tuerca.png', 250, 0, 50);
        $this->Ln(8);
        $this->SetX(2);
        $this->SetFont('Arial', 'B', 16);
        $this->SetFillColor(25, 41, 187);
        $this->SetTextColor(255, 255, 255);
        // Calcula la posición X para centrar la celda
        $cellWidth = 210; // Ancho de la celda
        $pageWidth = $this->GetPageWidth(); // Ancho de la página
        $x = ($pageWidth - $cellWidth) / 2;

        $this->SetX(70); // Establece la posición X
        $this->Cell(170, 12, utf8_decode($this->setTitulo('EMPLEADOS FILTRADOS')), 1, 0, 'C', true);
        $this->Ln(12);
    }

    function Footer()
    {
        $this->SetY(-27.5); // Posición desde el final
        $this->SetX(8.5); // Posición desde el final

        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'L');
        $fechaHora = date('d-m-Y h:i:s a');
        $this->Cell(0, 15, $fechaHora, 0, 0, 'R');

        $this->SetXY(10, -22);
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(25, 41, 187); // Azul
        $this->Cell(0, 8, 'ATLAS', 0, 0, 'L');
        $this->Image('../assets/img/icons/dasdad-transformed-removebg.png', 3, 188, 6);
        $this->Ln(8);

        // Imagen de pie de página (ancho completo)
        $image_position_letter_y = 62.5;
        $image_position_letter_x = 0;

        // Ajustar la posición Y de la imagen según el tamaño de la página
        $this->Image('../assets/img/images/pie.png',  $image_position_letter_x, $image_position_letter_y, $this->w);
    }

    //FILTRAR POR SEXO DEL TRABAJADOR
    public function generarPDFSexo(string $sexo)
    {
        $this->SetMargins(5, 0, 5); // Ajustar márgenes
        $this->AddPage();
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(25, 41, 187);
        $this->SetTextColor(255, 255, 255);
        $datosEmpleado = $this->personalData->getDatosEmpleadoFiltro('dp.sexo = ?',[$sexo]);
        $i = 0;
              // $this->SetTextColor(255, 255, 255); // Blanco
              $this->Cell(25, 8, utf8_decode('FILTRO'), 1, 0, 'C', true);
              $this->SetX(30); // Posición desde el final
              $this->SetTextColor(0, 0, 0);
              $this->Cell(90, 8, utf8_decode(ucfirst('SEXUALIDAD: '." ".$sexo)), 1, 0, 'L');
              $this->SetX(110); // Posición desde el final
              $this->SetTextColor(255, 255, 255);
              $this->Cell(60, 8, utf8_decode(ucfirst('CANTIDAD DE REGISTROS')), 1, 0, 'C', true);
              $this->SetTextColor(0, 0, 0);
              $contar = $this->personalData->contarDatos( ' COUNT(id_personal) AS contar', 'dp.sexo = ?', [$sexo]);
              $this->Cell(40, 8, utf8_decode(ucfirst($contar[0]['contar'])), 1, 0, 'C');
              $this->Ln(8);
        if (is_array($datosEmpleado)) {

            // Subtítulos fuera de la tabla
            $this->SetFillColor(13, 113, 237); // Azul claro
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(35, 10, utf8_decode('Nombre'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Cédula'), 1, 0, 'C', true);
            $this->Cell(40, 10, utf8_decode('Cargo'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Estatus'), 1, 0, 'C', true);
            $this->Cell(90, 10, utf8_decode('Dependencia'), 1, 0, 'C', true);
            $this->Cell(60, 10, utf8_decode('Departamento'), 1, 1, 'C', true);

            foreach ($datosEmpleado as $dato) {
                if (is_array($dato)) {
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de empleado', 'El usuario ' . $this->nombreUsuario . ' ha descargado un pdf de los empleados en tamaño carta formato vertical');

                    $i++;
                    $this->SetTextColor(0, 0, 0); // Blanco

                    $this->SetFont('Arial', 'B', 9);
                    // Contenido de la tabla
                    $this->Cell(35, 9, utf8_decode(ucfirst($dato['primerNombre'] ?? '') . ' ' . ucfirst($dato['primerApellido'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['cedula'] ?? '')), 1, 0, 'L');
                    $this->Cell(40, 9, utf8_decode(ucfirst($dato['cargo'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['estatus'] ?? '')), 1, 0, 'L');
                    $this->Cell(90, 9, utf8_decode(ucfirst($dato['dependencia'] ?? '')), 1, 0, 'L');
                    $this->Cell(60, 9, utf8_decode(ucfirst($dato['departamento'] ?? '')), 1, 1, 'L');
                }
            }
        }
        $this->Output('I', 'ficha_tecnica.pdf');
    }

    //FILTRAR POR EDAD DEL TRABAJADOR
    public function generarPDFedad(string $edad)
    {
        $this->SetMargins(5, 0, 5); // Ajustar márgenes
        $this->AddPage();
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(25, 41, 187);
        $this->SetTextColor(255, 255, 255);
        $datosEmpleado = $this->personalData->getDatosEmpleadoFiltro('dp.edadPersonal = ?',[$edad]);
        $i = 0;
        $contar = $this->personalData->contarDatos( ' COUNT(id_personal) AS contar', 'dp.edadPersonal = ?', [$edad]);

              // $this->SetTextColor(255, 255, 255); // Blanco
              $this->Cell(25, 8, utf8_decode('FILTRO'), 1, 0, 'C', true);
              $this->SetX(30); // Posición desde el final
              $this->SetTextColor(0, 0, 0);
              $this->Cell(70, 8, utf8_decode(ucfirst('EDAD: '." ".$edad)), 1, 0, 'L');
              $this->SetX(100); // Posición desde el final
              $this->SetTextColor(255, 255, 255);
              $this->Cell(60, 8, utf8_decode(ucfirst('CANTIDAD DE REGISTROS')), 1, 0, 'C', true);
              $this->SetTextColor(0, 0, 0);
              $this->Cell(40, 8, utf8_decode(ucfirst($contar[0]['contar'])), 1, 0, 'C');
              $this->Ln(8);
        if (is_array($datosEmpleado)) {

            // Subtítulos fuera de la tabla
            $this->SetFillColor(13, 113, 237); // Azul claro
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(35, 10, utf8_decode('Nombre'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Cédula'), 1, 0, 'C', true);
            $this->Cell(40, 10, utf8_decode('Cargo'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Estatus'), 1, 0, 'C', true);
            $this->Cell(90, 10, utf8_decode('Dependencia'), 1, 0, 'C', true);
            $this->Cell(60, 10, utf8_decode('Departamento'), 1, 1, 'C', true);

            foreach ($datosEmpleado as $dato) {
                if (is_array($dato)) {
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de empleado', 'El usuario ' . $this->nombreUsuario . ' ha descargado un pdf de los empleados en tamaño carta formato vertical');

                    $i++;
                    $this->SetTextColor(0, 0, 0); // Blanco

                    $this->SetFont('Arial', 'B', 9);
                    // Contenido de la tabla
                    $this->Cell(35, 9, utf8_decode(ucfirst($dato['primerNombre'] ?? '') . ' ' . ucfirst($dato['primerApellido'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['cedula'] ?? '')), 1, 0, 'L');
                    $this->Cell(40, 9, utf8_decode(ucfirst($dato['cargo'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['estatus'] ?? '')), 1, 0, 'L');
                    $this->Cell(90, 9, utf8_decode(ucfirst($dato['dependencia'] ?? '')), 1, 0, 'L');
                    $this->Cell(60, 9, utf8_decode(ucfirst($dato['departamento'] ?? '')), 1, 1, 'L');
                }
            }
        }
        $this->Output('I', 'ficha_tecnica.pdf');
    }

    //FILTRAR POR CARGO
    public function generarPDFCargo(string $cargo)
    {
        $this->SetMargins(5, 0, 5); // Ajustar márgenes
        $this->AddPage();
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(25, 41, 187);
        $this->SetTextColor(255, 255, 255);
        $datosEmpleado = $this->personalData->getDatosEmpleadoFiltro('c.id_cargo = ?',[$cargo]);
        $i = 0;
        $contar = $this->personalData->contarDatos( 'c.cargo, COUNT(id_cargo) AS contar', 'c.id_cargo = ?', [$cargo]);

              // $this->SetTextColor(255, 255, 255); // Blanco
              $this->Cell(25, 8, utf8_decode('FILTRO'), 1, 0, 'C', true);
              $this->SetX(30); // Posición desde el final
              $this->SetTextColor(0, 0, 0);
              $this->Cell(70, 8, utf8_decode(ucfirst('CARGO: '." ".$contar[0]['cargo'])), 1, 0, 'L');
              $this->SetX(100); // Posición desde el final
              $this->SetTextColor(255, 255, 255);
              $this->Cell(60, 8, utf8_decode(ucfirst('CANTIDAD DE REGISTROS')), 1, 0, 'C', true);
              $this->SetTextColor(0, 0, 0);
              $this->Cell(40, 8, utf8_decode(ucfirst($contar[0]['contar'])), 1, 0, 'C');
              $this->Ln(8);
        if (is_array($datosEmpleado)) {

            // Subtítulos fuera de la tabla
            $this->SetFillColor(13, 113, 237); // Azul claro
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(35, 10, utf8_decode('Nombre'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Cédula'), 1, 0, 'C', true);
            $this->Cell(40, 10, utf8_decode('Cargo'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Estatus'), 1, 0, 'C', true);
            $this->Cell(90, 10, utf8_decode('Dependencia'), 1, 0, 'C', true);
            $this->Cell(60, 10, utf8_decode('Departamento'), 1, 1, 'C', true);

            foreach ($datosEmpleado as $dato) {
                if (is_array($dato)) {
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de empleado', 'El usuario ' . $this->nombreUsuario . ' ha descargado un pdf de los empleados en tamaño carta formato vertical');

                    $i++;
                    $this->SetTextColor(0, 0, 0); // Blanco

                    $this->SetFont('Arial', 'B', 9);
                    // Contenido de la tabla
                    $this->Cell(35, 9, utf8_decode(ucfirst($dato['primerNombre'] ?? '') . ' ' . ucfirst($dato['primerApellido'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['cedula'] ?? '')), 1, 0, 'L');
                    $this->Cell(40, 9, utf8_decode(ucfirst($dato['cargo'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['estatus'] ?? '')), 1, 0, 'L');
                    $this->Cell(90, 9, utf8_decode(ucfirst($dato['dependencia'] ?? '')), 1, 0, 'L');
                    $this->Cell(60, 9, utf8_decode(ucfirst($dato['departamento'] ?? '')), 1, 1, 'L');
                }
            }
        }
        $this->Output('I', 'ficha_tecnica.pdf');
    }

    //ESTATUS
    public function generarPDFEstatus(string $estatus)
    {
        $this->SetMargins(5, 0, 5); // Ajustar márgenes
        $this->AddPage();
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(25, 41, 187);
        $this->SetTextColor(255, 255, 255);
        $datosEmpleado = $this->personalData->getDatosEmpleadoFiltro('e.id_estatus = ?',[$estatus]);
        $i = 0;
        $contar = $this->personalData->contarDatos( 'e.estatus, COUNT(dp.id_personal) AS contar', 'e.id_estatus = ?', [$estatus]);

              // $this->SetTextColor(255, 255, 255); // Blanco
              $this->Cell(25, 8, utf8_decode('FILTRO'), 1, 0, 'C', true);
              $this->SetX(30); // Posición desde el final
              $this->SetTextColor(0, 0, 0);
              $this->Cell(70, 8, utf8_decode(ucfirst('ESTATUS: '." ".$contar[0]['estatus'])), 1, 0, 'L');
              $this->SetX(100); // Posición desde el final
              $this->SetTextColor(255, 255, 255);
              $this->Cell(60, 8, utf8_decode(ucfirst('CANTIDAD DE REGISTROS')), 1, 0, 'C', true);
              $this->SetTextColor(0, 0, 0);
              $this->Cell(40, 8, utf8_decode(ucfirst($contar[0]['contar'])), 1, 0, 'C');
              $this->Ln(8);
        if (is_array($datosEmpleado)) {

            // Subtítulos fuera de la tabla
            $this->SetFillColor(13, 113, 237); // Azul claro
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(35, 10, utf8_decode('Nombre'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Cédula'), 1, 0, 'C', true);
            $this->Cell(40, 10, utf8_decode('Cargo'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Estatus'), 1, 0, 'C', true);
            $this->Cell(90, 10, utf8_decode('Dependencia'), 1, 0, 'C', true);
            $this->Cell(60, 10, utf8_decode('Departamento'), 1, 1, 'C', true);

            foreach ($datosEmpleado as $dato) {
                if (is_array($dato)) {
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de empleado', 'El usuario ' . $this->nombreUsuario . ' ha descargado un pdf de los empleados en tamaño carta formato vertical');

                    $i++;
                    $this->SetTextColor(0, 0, 0); // Blanco

                    $this->SetFont('Arial', 'B', 9);
                    // Contenido de la tabla
                    $this->Cell(35, 9, utf8_decode(ucfirst($dato['primerNombre'] ?? '') . ' ' . ucfirst($dato['primerApellido'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['cedula'] ?? '')), 1, 0, 'L');
                    $this->Cell(40, 9, utf8_decode(ucfirst($dato['cargo'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['estatus'] ?? '')), 1, 0, 'L');
                    $this->Cell(90, 9, utf8_decode(ucfirst($dato['dependencia'] ?? '')), 1, 0, 'L');
                    $this->Cell(60, 9, utf8_decode(ucfirst($dato['departamento'] ?? '')), 1, 1, 'L');
                }
            }
        }
        $this->Output('I', 'ficha_tecnica.pdf');
    }

    //ESTADO CIVIL
    public function generarPDFestadoCivil(string $estadoCivil)
    {
        $this->SetMargins(5, 0, 5); // Ajustar márgenes
        $this->AddPage();
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(25, 41, 187);
        $this->SetTextColor(255, 255, 255);
        $datosEmpleado = $this->personalData->getDatosEmpleadoFiltro('dp.estadoCivil = ?',[$estadoCivil]);
        $i = 0;
        $contar = $this->personalData->contarDatos( ' COUNT(dp.id_personal) AS contar', 'dp.estadoCivil = ?', [$estadoCivil]);

              // $this->SetTextColor(255, 255, 255); // Blanco
              $this->Cell(25, 8, utf8_decode('FILTRO'), 1, 0, 'C', true);
              $this->SetX(30); // Posición desde el final
              $this->SetTextColor(0, 0, 0);
              $this->Cell(70, 8, utf8_decode(ucfirst('ESTADO CIVIL: '." ". $estadoCivil)), 1, 0, 'L');
              $this->SetX(100); // Posición desde el final
              $this->SetTextColor(255, 255, 255);
              $this->Cell(60, 8, utf8_decode(ucfirst('CANTIDAD DE REGISTROS')), 1, 0, 'C', true);
              $this->SetTextColor(0, 0, 0);
              $this->Cell(40, 8, utf8_decode(ucfirst($contar[0]['contar'])), 1, 0, 'C');
              $this->Ln(8);
        if (is_array($datosEmpleado)) {

            // Subtítulos fuera de la tabla
            $this->SetFillColor(13, 113, 237); // Azul claro
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(35, 10, utf8_decode('Nombre'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Cédula'), 1, 0, 'C', true);
            $this->Cell(40, 10, utf8_decode('Cargo'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Estatus'), 1, 0, 'C', true);
            $this->Cell(90, 10, utf8_decode('Dependencia'), 1, 0, 'C', true);
            $this->Cell(60, 10, utf8_decode('Departamento'), 1, 1, 'C', true);

            foreach ($datosEmpleado as $dato) {
                if (is_array($dato)) {
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de empleado', 'El usuario ' . $this->nombreUsuario . ' ha descargado un pdf de los empleados en tamaño carta formato vertical');

                    $i++;
                    $this->SetTextColor(0, 0, 0); // Blanco

                    $this->SetFont('Arial', 'B', 9);
                    // Contenido de la tabla
                    $this->Cell(35, 9, utf8_decode(ucfirst($dato['primerNombre'] ?? '') . ' ' . ucfirst($dato['primerApellido'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['cedula'] ?? '')), 1, 0, 'L');
                    $this->Cell(40, 9, utf8_decode(ucfirst($dato['cargo'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['estatus'] ?? '')), 1, 0, 'L');
                    $this->Cell(90, 9, utf8_decode(ucfirst($dato['dependencia'] ?? '')), 1, 0, 'L');
                    $this->Cell(60, 9, utf8_decode(ucfirst($dato['departamento'] ?? '')), 1, 1, 'L');
                }
            }
        }
        $this->Output('I', 'ficha_tecnica.pdf');
    }

    //VIVIENDA
    public function generarPDFvivienda(string $vivienda)
    {
        $this->SetMargins(5, 0, 5); // Ajustar márgenes
        $this->AddPage();
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(25, 41, 187);
        $this->SetTextColor(255, 255, 255);
        $datosEmpleado = $this->personalData->getDatosEmpleadoFiltro('ubi.vivienda = ?',[$vivienda]);
        $i = 0;
        $contar = $this->personalData->contarDatos( ' COUNT(dp.id_personal) AS contar', 'ubi.vivienda = ?', [$vivienda]);

              // $this->SetTextColor(255, 255, 255); // Blanco
              $this->Cell(25, 8, utf8_decode('FILTRO'), 1, 0, 'C', true);
              $this->SetX(30); // Posición desde el final
              $this->SetTextColor(0, 0, 0);
              $this->Cell(70, 8, utf8_decode(ucfirst('VIVIENDA: '." ". $vivienda)), 1, 0, 'L');
              $this->SetX(100); // Posición desde el final
              $this->SetTextColor(255, 255, 255);
              $this->Cell(60, 8, utf8_decode(ucfirst('CANTIDAD DE REGISTROS')), 1, 0, 'C', true);
              $this->SetTextColor(0, 0, 0);
              $this->Cell(40, 8, utf8_decode(ucfirst($contar[0]['contar'])), 1, 0, 'C');
              $this->Ln(8);
        if (is_array($datosEmpleado)) {

            // Subtítulos fuera de la tabla
            $this->SetFillColor(13, 113, 237); // Azul claro
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(35, 10, utf8_decode('Nombre'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Cédula'), 1, 0, 'C', true);
            $this->Cell(40, 10, utf8_decode('Cargo'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Estatus'), 1, 0, 'C', true);
            $this->Cell(90, 10, utf8_decode('Dependencia'), 1, 0, 'C', true);
            $this->Cell(60, 10, utf8_decode('Departamento'), 1, 1, 'C', true);

            foreach ($datosEmpleado as $dato) {
                if (is_array($dato)) {
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de empleado', 'El usuario ' . $this->nombreUsuario . ' ha descargado un pdf de los empleados en tamaño carta formato vertical');

                    $i++;
                    $this->SetTextColor(0, 0, 0); // Blanco

                    $this->SetFont('Arial', 'B', 9);
                    // Contenido de la tabla
                    $this->Cell(35, 9, utf8_decode(ucfirst($dato['primerNombre'] ?? '') . ' ' . ucfirst($dato['primerApellido'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['cedula'] ?? '')), 1, 0, 'L');
                    $this->Cell(40, 9, utf8_decode(ucfirst($dato['cargo'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['estatus'] ?? '')), 1, 0, 'L');
                    $this->Cell(90, 9, utf8_decode(ucfirst($dato['dependencia'] ?? '')), 1, 0, 'L');
                    $this->Cell(60, 9, utf8_decode(ucfirst($dato['departamento'] ?? '')), 1, 1, 'L');
                }
            }
        }
        $this->Output('I', 'ficha_tecnica.pdf');
    }

    //NIVEL ACADEMICO
    public function generarPDFnivelAcademico(string $nivelAcademico)
    {
        $this->SetMargins(5, 0, 5); // Ajustar márgenes
        $this->AddPage();
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(25, 41, 187);
        $this->SetTextColor(255, 255, 255);
        $datosEmpleado = $this->personalData->getDatosEmpleadoFiltro('de.nivelAcademico = ?',[$nivelAcademico]);
        $i = 0;
        $contar = $this->personalData->contarDatos( ' COUNT(dp.id_personal) AS contar', 'de.nivelAcademico = ?', [$nivelAcademico]);

              // $this->SetTextColor(255, 255, 255); // Blanco
              $this->Cell(25, 8, utf8_decode('FILTRO'), 1, 0, 'C', true);
              $this->SetX(30); // Posición desde el final
              $this->SetTextColor(0, 0, 0);
              $this->Cell(70, 8, utf8_decode(ucfirst('NIVEL ACADEMICO: '." ". $nivelAcademico)), 1, 0, 'L');
              $this->SetX(100); // Posición desde el final
              $this->SetTextColor(255, 255, 255);
              $this->Cell(60, 8, utf8_decode(ucfirst('CANTIDAD DE REGISTROS')), 1, 0, 'C', true);
              $this->SetTextColor(0, 0, 0);
              $this->Cell(40, 8, utf8_decode(ucfirst($contar[0]['contar'])), 1, 0, 'C');
              $this->Ln(8);
        if (is_array($datosEmpleado)) {

            // Subtítulos fuera de la tabla
            $this->SetFillColor(13, 113, 237); // Azul claro
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(35, 10, utf8_decode('Nombre'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Cédula'), 1, 0, 'C', true);
            $this->Cell(40, 10, utf8_decode('Cargo'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Estatus'), 1, 0, 'C', true);
            $this->Cell(90, 10, utf8_decode('Dependencia'), 1, 0, 'C', true);
            $this->Cell(60, 10, utf8_decode('Departamento'), 1, 1, 'C', true);

            foreach ($datosEmpleado as $dato) {
                if (is_array($dato)) {
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de empleado', 'El usuario ' . $this->nombreUsuario . ' ha descargado un pdf de los empleados en tamaño carta formato vertical');

                    $i++;
                    $this->SetTextColor(0, 0, 0); // Blanco

                    $this->SetFont('Arial', 'B', 9);
                    // Contenido de la tabla
                    $this->Cell(35, 9, utf8_decode(ucfirst($dato['primerNombre'] ?? '') . ' ' . ucfirst($dato['primerApellido'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['cedula'] ?? '')), 1, 0, 'L');
                    $this->Cell(40, 9, utf8_decode(ucfirst($dato['cargo'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['estatus'] ?? '')), 1, 0, 'L');
                    $this->Cell(90, 9, utf8_decode(ucfirst($dato['dependencia'] ?? '')), 1, 0, 'L');
                    $this->Cell(60, 9, utf8_decode(ucfirst($dato['departamento'] ?? '')), 1, 1, 'L');
                }
            }
        }
        $this->Output('I', 'ficha_tecnica.pdf');
    }

    //NIVEL DEPENDENCIA
    public function generarPDFdependencia(string $dependencia)
    {
        $this->SetMargins(5, 0, 5); // Ajustar márgenes
        $this->AddPage();
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(25, 41, 187);
        $this->SetTextColor(255, 255, 255);
        $datosEmpleado = $this->personalData->getDatosEmpleadoFiltro('de.idDependencia = ?',[$dependencia]);
        $i = 0;
        $contar = $this->personalData->contarDatos( 'depe.dependencia, COUNT(dp.id_personal) AS contar', 'de.idDependencia = ?', [$dependencia]);

              // $this->SetTextColor(255, 255, 255); // Blanco
              $this->Cell(25, 8, utf8_decode('FILTRO'), 1, 0, 'C', true);
              $this->SetX(30); // Posición desde el final
              $this->SetTextColor(0, 0, 0);
              $this->Cell(160, 8, utf8_decode(ucfirst('DEPENDENCIA: '." ". $contar[0]['dependencia'])), 1, 0, 'L');
              $this->SetX(190); // Posición desde el final
              $this->SetTextColor(255, 255, 255);
              $this->Cell(60, 8, utf8_decode(ucfirst('CANTIDAD DE REGISTROS')), 1, 0, 'C', true);
              $this->SetTextColor(0, 0, 0);
              $this->Cell(40, 8, utf8_decode(ucfirst($contar[0]['contar'])), 1, 0, 'C');
              $this->Ln(8);
        if (is_array($datosEmpleado)) {

            // Subtítulos fuera de la tabla
            $this->SetFillColor(13, 113, 237); // Azul claro
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(35, 10, utf8_decode('Nombre'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Cédula'), 1, 0, 'C', true);
            $this->Cell(40, 10, utf8_decode('Cargo'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Estatus'), 1, 0, 'C', true);
            $this->Cell(90, 10, utf8_decode('Dependencia'), 1, 0, 'C', true);
            $this->Cell(60, 10, utf8_decode('Departamento'), 1, 1, 'C', true);

            foreach ($datosEmpleado as $dato) {
                if (is_array($dato)) {
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de empleado', 'El usuario ' . $this->nombreUsuario . ' ha descargado un pdf de los empleados en tamaño carta formato vertical');

                    $i++;
                    $this->SetTextColor(0, 0, 0); // Blanco

                    $this->SetFont('Arial', 'B', 9);
                    // Contenido de la tabla
                    $this->Cell(35, 9, utf8_decode(ucfirst($dato['primerNombre'] ?? '') . ' ' . ucfirst($dato['primerApellido'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['cedula'] ?? '')), 1, 0, 'L');
                    $this->Cell(40, 9, utf8_decode(ucfirst($dato['cargo'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['estatus'] ?? '')), 1, 0, 'L');
                    $this->Cell(90, 9, utf8_decode(ucfirst($dato['dependencia'] ?? '')), 1, 0, 'L');
                    $this->Cell(60, 9, utf8_decode(ucfirst($dato['departamento'] ?? '')), 1, 1, 'L');
                }
            }
        }
        $this->Output('I', 'ficha_tecnica.pdf');
    }

    //NIVEL DEPARTAMENTO
    public function generarPDFdepartamento(string $departamento)
    {
        $this->SetMargins(5, 0, 5); // Ajustar márgenes
        $this->AddPage();
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(25, 41, 187);
        $this->SetTextColor(255, 255, 255);
        $datosEmpleado = $this->personalData->getDatosEmpleadoFiltro('de.idDepartamento = ?',[$departamento]);
        $i = 0;
        $contar = $this->personalData->contarDatos( 'd.departamento, COUNT(dp.id_personal) AS contar', 'de.idDepartamento = ?', [$departamento]);

              // $this->SetTextColor(255, 255, 255); // Blanco
              $this->Cell(25, 8, utf8_decode('FILTRO'), 1, 0, 'C', true);
              $this->SetX(30); // Posición desde el final
              $this->SetTextColor(0, 0, 0);
              $this->Cell(160, 8, utf8_decode(ucfirst('DEPARTAMENTO: '." ". $contar[0]['departamento'])), 1, 0, 'L');
              $this->SetX(190); // Posición desde el final
              $this->SetTextColor(255, 255, 255);
              $this->Cell(60, 8, utf8_decode(ucfirst('CANTIDAD DE REGISTROS')), 1, 0, 'C', true);
              $this->SetTextColor(0, 0, 0);
              $this->Cell(40, 8, utf8_decode(ucfirst($contar[0]['contar'])), 1, 0, 'C');
              $this->Ln(8);
        if (is_array($datosEmpleado)) {

            // Subtítulos fuera de la tabla
            $this->SetFillColor(13, 113, 237); // Azul claro
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(35, 10, utf8_decode('Nombre'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Cédula'), 1, 0, 'C', true);
            $this->Cell(40, 10, utf8_decode('Cargo'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Estatus'), 1, 0, 'C', true);
            $this->Cell(90, 10, utf8_decode('Dependencia'), 1, 0, 'C', true);
            $this->Cell(60, 10, utf8_decode('Departamento'), 1, 1, 'C', true);

            foreach ($datosEmpleado as $dato) {
                if (is_array($dato)) {
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de empleado', 'El usuario ' . $this->nombreUsuario . ' ha descargado un pdf de los empleados en tamaño carta formato vertical');

                    $i++;
                    $this->SetTextColor(0, 0, 0); // Blanco

                    $this->SetFont('Arial', 'B', 9);
                    // Contenido de la tabla
                    $this->Cell(35, 9, utf8_decode(ucfirst($dato['primerNombre'] ?? '') . ' ' . ucfirst($dato['primerApellido'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['cedula'] ?? '')), 1, 0, 'L');
                    $this->Cell(40, 9, utf8_decode(ucfirst($dato['cargo'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['estatus'] ?? '')), 1, 0, 'L');
                    $this->Cell(90, 9, utf8_decode(ucfirst($dato['dependencia'] ?? '')), 1, 0, 'L');
                    $this->Cell(60, 9, utf8_decode(ucfirst($dato['departamento'] ?? '')), 1, 1, 'L');
                }
            }
        }
        $this->Output('I', 'ficha_tecnica.pdf');
    }

    //NIVEL DIRECCION
    public function generarPDFdireccion(string $estado, string $municipio, $parroquia)
    {
        $this->SetMargins(5, 0, 5); // Ajustar márgenes
        $this->AddPage();
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(25, 41, 187);
        $this->SetTextColor(255, 255, 255);
        $datosEmpleado = $this->personalData->getDatosEmpleadoFiltro('ubi.idEstado = ? AND ubi.idMunicipio  = ? AND ubi.idParroquia  = ?',[$estado, $municipio, $parroquia]);
        $i = 0;
        $contar = $this->personalData->contarDatos( 'est.estado, m.municipio, p.parroquia, COUNT(dp.id_personal) AS contar', 'ubi.idEstado = ? AND ubi.idMunicipio  = ? AND ubi.idParroquia  = ?', [$estado, $municipio, $parroquia]);

              // $this->SetTextColor(255, 255, 255); // Blanco
              $this->Cell(25, 8, utf8_decode('FILTRO'), 1, 0, 'C', true);
              $this->SetX(30); // Posición desde el final
              $this->SetTextColor(0, 0, 0);
              $this->Cell(180, 8, utf8_decode(ucfirst('DERECCION:'." "."Estado:"." ".$contar[0]['estado'].","."Municipio:"." ".$contar[0]['municipio'].","."Parroquia:"." ". $contar[0]['parroquia'])), 1, 0, 'L');
              $this->SetX(210); // Posición desde el final
              $this->SetTextColor(255, 255, 255);
              $this->Cell(60, 8, utf8_decode(ucfirst('CANTIDAD DE REGISTROS')), 1, 0, 'C', true);
              $this->SetTextColor(0, 0, 0);
              $this->Cell(20, 8, utf8_decode(ucfirst($contar[0]['contar'])), 1, 0, 'C');
              $this->Ln(8);
        if (is_array($datosEmpleado)) {

            // Subtítulos fuera de la tabla
            $this->SetFillColor(13, 113, 237); // Azul claro
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(35, 10, utf8_decode('Nombre'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Cédula'), 1, 0, 'C', true);
            $this->Cell(40, 10, utf8_decode('Cargo'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Estatus'), 1, 0, 'C', true);
            $this->Cell(90, 10, utf8_decode('Dependencia'), 1, 0, 'C', true);
            $this->Cell(60, 10, utf8_decode('Departamento'), 1, 1, 'C', true);

            foreach ($datosEmpleado as $dato) {
                if (is_array($dato)) {
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de empleado', 'El usuario ' . $this->nombreUsuario . ' ha descargado un pdf de los empleados en tamaño carta formato vertical');

                    $i++;
                    $this->SetTextColor(0, 0, 0); // Blanco

                    $this->SetFont('Arial', 'B', 9);
                    // Contenido de la tabla
                    $this->Cell(35, 9, utf8_decode(ucfirst($dato['primerNombre'] ?? '') . ' ' . ucfirst($dato['primerApellido'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['cedula'] ?? '')), 1, 0, 'L');
                    $this->Cell(40, 9, utf8_decode(ucfirst($dato['cargo'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['estatus'] ?? '')), 1, 0, 'L');
                    $this->Cell(90, 9, utf8_decode(ucfirst($dato['dependencia'] ?? '')), 1, 0, 'L');
                    $this->Cell(60, 9, utf8_decode(ucfirst($dato['departamento'] ?? '')), 1, 1, 'L');
                }
            }
        }
        $this->Output('I', 'ficha_tecnica.pdf');
    }

    //RANGO DE FECHAS, FECHA INICIO Y FECHA FIN
    public function generarPDFrangoFhecha(string $fecha_Ini, string $fecha_Fin, string $fecha_IniESPA, string $fecha_FinESPA)
    {
        $this->SetMargins(5, 0, 5); // Ajustar márgenes
        $this->AddPage();
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(25, 41, 187);
        $this->SetTextColor(255, 255, 255);
        $datosEmpleado = $this->personalData->getDatosEmpleadoFiltro('de.fechaING BETWEEN ? AND ?',[$fecha_Ini, $fecha_Fin]);
        $i = 0;
        $contar = $this->personalData->contarDatos( 'COUNT(dp.id_personal) AS contar', 'de.fechaING BETWEEN ? AND ?', [$fecha_Ini, $fecha_Fin]);

              // $this->SetTextColor(255, 255, 255); // Blanco
              $this->Cell(25, 8, utf8_decode('FILTRO'), 1, 0, 'C', true);
              $this->SetX(30); // Posición desde el final
              $this->SetTextColor(0, 0, 0);
              $this->Cell(180, 8, utf8_decode(ucfirst('RANGO DE FECHA:'." "."Fecha inicio:"." ".$fecha_IniESPA."    "."Fecha fin:"." ".$fecha_FinESPA)), 1, 0, 'L');
              $this->SetX(210); // Posición desde el final
              $this->SetTextColor(255, 255, 255);
              $this->Cell(60, 8, utf8_decode(ucfirst('CANTIDAD DE REGISTROS')), 1, 0, 'C', true);
              $this->SetTextColor(0, 0, 0);
              $this->Cell(20, 8, utf8_decode(ucfirst($contar[0]['contar'])), 1, 0, 'C');
              $this->Ln(8);
        if (is_array($datosEmpleado)) {

            // Subtítulos fuera de la tabla
            $this->SetFillColor(13, 113, 237); // Azul claro
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(35, 10, utf8_decode('Nombre'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Cédula'), 1, 0, 'C', true);
            $this->Cell(40, 10, utf8_decode('Cargo'), 1, 0, 'C', true);
            $this->Cell(30, 10, utf8_decode('Estatus'), 1, 0, 'C', true);
            $this->Cell(90, 10, utf8_decode('Dependencia'), 1, 0, 'C', true);
            $this->Cell(60, 10, utf8_decode('Departamento'), 1, 1, 'C', true);

            foreach ($datosEmpleado as $dato) {
                if (is_array($dato)) {
                    $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descarga pdf de empleado', 'El usuario ' . $this->nombreUsuario . ' ha descargado un pdf de los empleados en tamaño A4 formato horizontal por rango de fecha, desde:'." ". $fecha_IniESPA."    ". "hasta:"." ".$fecha_FinESPA);

                    $i++;
                    $this->SetTextColor(0, 0, 0); // Blanco

                    $this->SetFont('Arial', 'B', 9);
                    // Contenido de la tabla
                    $this->Cell(35, 9, utf8_decode(ucfirst($dato['primerNombre'] ?? '') . ' ' . ucfirst($dato['primerApellido'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['cedula'] ?? '')), 1, 0, 'L');
                    $this->Cell(40, 9, utf8_decode(ucfirst($dato['cargo'] ?? '')), 1, 0, 'L');
                    $this->Cell(30, 9, utf8_decode(ucfirst($dato['estatus'] ?? '')), 1, 0, 'L');
                    $this->Cell(90, 9, utf8_decode(ucfirst($dato['dependencia'] ?? '')), 1, 0, 'L');
                    $this->Cell(60, 9, utf8_decode(ucfirst($dato['departamento'] ?? '')), 1, 1, 'L');
                }
            }
        }
        $this->Output('I', 'ficha_tecnica.pdf');
    }
}
// Ejemplo de uso
