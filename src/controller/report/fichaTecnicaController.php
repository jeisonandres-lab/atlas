<?php

namespace App\Atlas\controller\report;

use App\Atlas\models\personalModel;
use App\Atlas\controller\auditoriaController;
use App\Atlas\config\App;

use  FPDF; // Importa la clase pdfController

date_default_timezone_set("America/Caracas");

class fichaTecnicaController extends FPDF
{
    private $personalData;
    private $pdf;
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
    public $title = 'Ficha Técnica'; // Título del reporte
    public $page_size;

    private $app;
    private $auditoriaController;
    private $idUsuario;
    private $nombreUsuario;

    public function __construct($orientation = 'P', $unit = 'mm', $size = 'Letter')
    {
        parent::__construct($orientation, $unit, $size);
        $this->personalData = new personalModel();
        $this->pdf = new pdfController($orientation, $unit, $size); // Crear una instancia de pdfController con los parámetros
        $this->AliasNbPages(); // Define el alias {nb}
        $this->app = new App();
        $this->auditoriaController = new auditoriaController();
        $this->app->iniciarSession();
        $this->idUsuario = $_SESSION['id'];
        $this->nombreUsuario = $_SESSION['usuario'];
    }

    function Header()
    {
        // Logo o imagen de cabecera (izquierda)
        $this->Image('../assets/img/images/inces.png', 10, 2, 30);

        // Logo o imagen de cabecera (derecha) - Ajusta la posición según necesites
        $this->Image('../assets/img/images/tuerca.png', 170, -4, 50);
        $this->Ln(8);
        // Título principal
        $this->SetX(2);
        $this->SetFont('Arial', 'B', 16);
        $this->SetFillColor(25, 41, 187); // Azul
        $this->SetTextColor(255, 255, 255); // Blanco
        $this->Cell(210, 12, utf8_decode($this->title), 1, 0, 'C', true);
        $this->Ln(12);

    }

    function Footer()
    {
        $this->SetY(-27.5); // Posición desde el final
        $this->SetX(8.5); // Posición desde el final

        // Número de página y fecha/hora
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 15, utf8_decode('Página') . $this->PageNo() . '/{nb}', 0, 0, 'L');
        $fechaHora = date('d-m-Y h:i:s a');
        $this->Cell(0, 15, $fechaHora, 0, 0, 'R');


        $this->SetXY(12, -18);
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(25, 41, 187); // Azul
        $this->Cell(0, 8, 'ATLAS', 0, 0, 'L');
        $this->Image('../assets/img/icons/dasdad-transformed-removebg.png', 3, 262, 6);
        $this->Ln(8);

        // Imagen de pie de página (ancho completo)
        $image_position_letter_y = 172;
        $image_position_letter_x = 0;

        // Ajustar la posición Y de la imagen según el tamaño de la página
        $this->Image('../assets/img/images/pie.png',  $image_position_letter_x, $image_position_letter_y, $this->w);
    }

    function generarFicha(string $idCedula)
    {
        $this->AddPage();
        $this->SetFont('Arial', 'B', 10);
        $parametro = [$idCedula];
        $datosPersonal = $this->personalData->getTotalDatosCDEmpleados($parametro);
        $this->SetDrawColor(0,0,0); // Negro
        foreach ($datosPersonal as $row) {
            // echo "<pre>";
            // var_dump($row);
            // echo "</pre>";
            $parametroID = [$row['cedula']];
            $parametronombre = $row['primerNombre'].' '.$row['primerApellido'];

            $registroAuditoria = $this->auditoriaController->registrarAuditoria($this->idUsuario, 'Descargar ficha técnica', 'El usuario'. $this->nombreUsuario. ' a generado la ficha técnica del empleado '. $parametronombre);


            $rutaImagen = '../global/archives/photos/' . $parametroID[0] . '.png';

            if (file_exists($rutaImagen)) {
                $this->Image($rutaImagen, 2, 30.2, 65, 59);
                // Dibuja el borde alrededor de la imagen
                $this->Rect(2, 30, 65, 66); // x, y, ancho, alto
            } else {
                $this->Cell(80, 80, 'Sin foto', 1, 0, 'C'); // Celda para "Sin foto" con borde
            }

            $this->SetDrawColor(0, 0, 0); // Negro
            // Celda para Cédula con fondo azul
            $this->SetX(67);
            $this->SetFillColor(40, 109, 209); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(33, 8, utf8_decode('Cédula'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(112, 8, utf8_decode($row['cedula'] ?? ''), 1, 0, 'L');
            $this->Ln(8);

            $this->SetX(67);
            $this->SetFillColor(40, 109, 209); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(33, 8, utf8_decode('Nombre'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(112, 8, utf8_decode($row['primerNombre'] ?? '') . ' ' . utf8_decode($row['primerApellido']), 1, 0, 'L');
            $this->Ln(8);

            // Resto de las celdas (sin fondo azul, texto negro)
            $this->SetX(67);
            $this->SetFillColor(40, 109, 209); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(33, 8, utf8_decode('Cargo'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(112, 8, utf8_decode($row['cargo'] ?? ''), 1, 0, 'L');
            $this->Ln(8);

            // Resto de las celdas (sin fondo azul, texto negro)
            $this->SetX(67);
            $this->SetFillColor(40, 109, 209); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(33, 8, utf8_decode('Estatus'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(112, 8, utf8_decode($row['estatus'] ?? ''), 1, 0, 'L');
            $this->Ln(8);

            $this->SetX(67);
            $this->SetFillColor(40, 109, 209); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(33, 8, utf8_decode('Departamento'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(112, 8, utf8_decode($row['departamento'] ?? ''), 1, 0, 'L');
            $this->Ln(8);

            $this->SetX(67);
            $this->SetFillColor(40, 109, 209); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(33, 8, utf8_decode('Dependencia'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(112, 8, utf8_decode($row['dependencia'] ?? ''), 1, 0, 'L');
            $this->Ln(8);

            $this->SetX(67);
            $this->SetFillColor(40, 109, 209); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(33, 8, utf8_decode('Ingreso'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(112, 8, utf8_decode($row['fechaING'] ?? ''), 1, 0, 'L');
            $this->Ln(8);

            // TITULO DEL APARTADO DE DATOS PERSONALES
            $this->SetDrawColor(0, 0, 0); // Negro
            $this->SetX(2);
            $this->SetFont('Arial', 'B', 10);
            $this->SetFillColor(25, 41, 187); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(210, 10, utf8_decode('DATOS PERSONALES'), 1, 0, 'C', true); // Celda con borde y relleno

            $this->Ln(10);
            $this->SetX(2);


            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(22, 8, utf8_decode('P.Nombre'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(25, 8, utf8_decode($row['primerNombre'] ?? ''), 1, 0, 'L');

            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(22, 8, utf8_decode('S.Nombre'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(25, 8, utf8_decode($row['segundoNombre'] ?? ''), 1, 0, 'L');


            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(30, 8, utf8_decode('P.Apellido'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(28, 8, utf8_decode($row['primerApellido'] ?? ''), 1, 0, 'L');

            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(30, 8, utf8_decode('S.Apellido'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(28, 8, utf8_decode($row['segundoApellido'] ?? ''), 1, 0, 'L');

            $this->Ln(8);
            $this->SetX(2);

            $this->SetFont('Arial', 'B', 10);
            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(22, 8, utf8_decode('Cédula'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(25, 8, utf8_decode($row['cedula'] ?? ''), 1, 0, 'L');

            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(37, 8, utf8_decode('Fecha Nacimiento'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(30, 8, utf8_decode($row['diaNacimiento'] . '-' . $row['mesNacimiento'] . '-' . $row['anoNacimiento']), 1, 0, 'L');


            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(30, 8, utf8_decode('Estado Civil'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(66, 8, utf8_decode($row['estadoCivil'] ?? ''), 1, 0, 'L');


            // TITULO DEL APARTADO DE FICHA TECNICAS
            $this->Ln(8);
            $this->SetX(2);
            $this->SetFont('Arial', 'B', 10);
            $this->SetFillColor(25, 41, 187); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(210, 10, utf8_decode('DATOS DE EMPLEADO'), 1, 0, 'C', true); // Celda con borde y relleno

            $this->Ln(10);

            $this->SetX(2);

            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(35, 8, utf8_decode('Departamento'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(50, 8, utf8_decode($row['departamento'] ?? ''), 1, 0, 'L');

            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(30, 8, utf8_decode('Dependencia'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(95, 8, utf8_decode($row['dependencia'] ?? ''), 1, 0, 'L');

            $this->Ln(8);

            $this->SetX(2);

            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(20, 8, utf8_decode('Cargo'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(35, 8, utf8_decode($row['cargo'] ?? ''), 1, 0, 'L');

            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(20, 8, utf8_decode('Estatus'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(40, 8, utf8_decode($row['estatus'] ?? ''), 1, 0, 'L');

            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(27, 8, utf8_decode('N.Academico'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(68, 8, utf8_decode($row['nivelAcademico'] ?? ''), 1, 0, 'L');


            $this->Ln(8);

            $this->SetX(2);

            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(20, 8, utf8_decode('Ingreso'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(35, 8, utf8_decode($row['fechaING'] ?? ''), 1, 0, 'L');

            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(30, 8, utf8_decode('EST.Empleado'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(30, 8, utf8_decode($row['estadoEmpleado'] ?? ''), 1, 0, 'L');

            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(20, 8, utf8_decode('Teléfono'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(28, 8, utf8_decode($row['telefono'] ?? ''), 1, 0, 'L');

            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(20, 8, utf8_decode('T.Oficina'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(27, 8, utf8_decode($row['telOficina'] ?? ''), 1, 0, 'L');


            $this->Ln(8);

            $this->SetX(2);
            $this->SetFillColor(93, 173, 226); // Azul
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(25, 8, utf8_decode('Correo'), 1, 0, 'L', true); // Celda con borde y relleno
            $this->SetTextColor(0, 0, 0); // Blanco
            $this->Cell(185, 8, utf8_decode($row['correo'] ?? ''), 1, 0, 'L');


            $this->Ln(8);
            // TITULO DEL APARTADO DE DATOS Familiar
            $this->SetDrawColor(0, 0, 0); // Negro
            $this->SetX(2);
            $this->SetFont('Arial', 'B', 10);
            $this->SetFillColor(25, 41, 187); // Azul 133, 193, 233
            $this->SetTextColor(255, 255, 255); // Blanco
            $this->Cell(210, 10, utf8_decode('DATOS FAMILIAR'), 1, 0, 'C', true); // Celda con borde y relleno

            $parametroBuscarFamiliar = [$row['id_empleados']];
            $datosFamiliar = $this->personalData->getDatosFamiliarEmpleadoID($parametroBuscarFamiliar);

            if (is_array($datosFamiliar) && !empty($datosFamiliar)) {
                $i = 1;
                foreach ($datosFamiliar as $rowF) {
                    // echo "<pre>";
                    // var_dump($rowF);
                    // echo "</pre>";
                    $this->Ln(8);

                    $this->SetDrawColor(0, 0, 0); // Negro
                    $this->SetX(2);
                    $this->SetFont('Arial', 'B', 10);
                    $this->SetFillColor(25, 41, 187); // Azul
                    $this->SetTextColor(255, 255, 255); // Blanco
                    $this->Cell(50, 10, utf8_decode(''), 1, 0, 'C', true);
                    $this->SetFillColor(40, 109, 209); // Azul
                    $this->Cell(110, 10, utf8_decode('FAMILIAR' . ' ' . $i++), 1, 0, 'C', true);
                    $this->SetFillColor(25, 41, 187); // Azul
                    $this->Cell(50, 10, utf8_decode(''), 1, 0, 'C', true); // Celda con borde y relleno

                    $this->Ln(10);
                    $this->SetX(2);


                    $this->SetFillColor(93, 173, 226); // Azul
                    $this->SetTextColor(255, 255, 255); // Blanco
                    $this->Cell(25, 8, utf8_decode('P.Nombre'), 1, 0, 'L', true); // Celda con borde y relleno
                    $this->SetTextColor(0, 0, 0); // Blanco
                    $this->Cell(25, 8, utf8_decode($rowF['primerNombreFamiliar'] ?? ''), 1, 0, 'L');

                    $this->SetFillColor(93, 173, 226); // Azul
                    $this->SetTextColor(255, 255, 255); // Blanco
                    $this->Cell(25, 8, utf8_decode('S.Nombre'), 1, 0, 'L', true); // Celda con borde y relleno
                    $this->SetTextColor(0, 0, 0); // Blanco
                    $this->Cell(29, 8, utf8_decode($rowF['segundoNombreFamiliar'] ?? ''), 1, 0, 'L');


                    $this->SetFillColor(93, 173, 226); // Azul
                    $this->SetTextColor(255, 255, 255); // Blanco
                    $this->Cell(25, 8, utf8_decode('P.Apellido'), 1, 0, 'L', true); // Celda con borde y relleno
                    $this->SetTextColor(0, 0, 0); // Blanco
                    $this->Cell(29, 8, utf8_decode($rowF['primerApellidoFamiliar'] ?? ''), 1, 0, 'L');

                    $this->SetFillColor(93, 173, 226); // Azul
                    $this->SetTextColor(255, 255, 255); // Blanco
                    $this->Cell(25, 8, utf8_decode('S.Apellido'), 1, 0, 'L', true); // Celda con borde y relleno
                    $this->SetTextColor(0, 0, 0); // Blanco
                    $this->Cell(27, 8, utf8_decode($rowF['segundoApellidoFamiliar'] ?? ''), 1, 0, 'L');


                    $this->Ln(8);
                    $this->SetX(2);

                    $this->SetFillColor(93, 173, 226); // Azul
                    $this->SetTextColor(255, 255, 255); // Blanco
                    $this->Cell(25, 8, utf8_decode('Cédula'), 1, 0, 'L', true); // Celda con borde y relleno
                    $this->SetTextColor(0, 0, 0); // Blanco
                    $this->Cell(25, 8, utf8_decode($rowF['cedulaFamiliar'] ?? ''), 1, 0, 'L');

                    $this->SetFillColor(93, 173, 226); // Azul
                    $this->SetTextColor(255, 255, 255); // Blanco
                    $this->Cell(35, 8, utf8_decode('Fecha Nacimiento'), 1, 0, 'L', true); // Celda con borde y relleno
                    $this->SetTextColor(0, 0, 0); // Blanco
                    $this->Cell(25, 8, utf8_decode($rowF['diaNacimientoFamiliar'] . '-' . $rowF['mesNacimientoFamiliar'] . '-' . $rowF['anoNacimientoFamiliar']), 1, 0, 'L');

                    $this->SetFillColor(93, 173, 226); // Azul
                    $this->SetTextColor(255, 255, 255); // Blanco
                    $this->Cell(25, 8, utf8_decode('Parentesco'), 1, 0, 'L', true); // Celda con borde y relleno
                    $this->SetTextColor(0, 0, 0); // Blanco
                    $this->Cell(28, 8, utf8_decode($rowF['parentesco'] ?? ''), 1, 0, 'L');

                    $this->SetFillColor(93, 173, 226); // Azul
                    $this->SetTextColor(255, 255, 255); // Blanco
                    $this->Cell(20, 8, utf8_decode('edad'), 1, 0, 'L', true); // Celda con borde y relleno
                    $this->SetTextColor(0, 0, 0); // Blanco
                    $this->Cell(27, 8, utf8_decode($rowF['edad'] ?? ''), 1, 0, 'L');

                    if ($rowF['codigoCarnet'] == '') {
                        $this->Ln(8);
                        $this->SetX(2);
                        $this->SetFillColor(93, 173, 226); // Azul
                        $this->SetTextColor(255, 255, 255); // Blanco
                        $this->Cell(25, 8, utf8_decode('Diagnostico'), 1, 0, 'L', true); // Celda con borde y relleno
                        $this->SetTextColor(0, 0, 0); // Blanco
                        $this->Cell(185, 8, utf8_decode('Sin Discapacidad'), 1, 0, 'L');
                    } else {
                        $this->Ln(8);
                        $this->SetX(2);
                        $this->SetFillColor(93, 173, 226); // Azul
                        $this->SetTextColor(255, 255, 255); // Blanco
                        $this->Cell(25, 8, utf8_decode('N.Carnet'), 1, 0, 'L', true); // Celda con borde y relleno
                        $this->SetTextColor(0, 0, 0); // Blanco
                        $this->Cell(33, 8, utf8_decode($rowF['codigoCarnet'] ?? ''), 1, 0, 'L');

                        $this->SetFillColor(93, 173, 226); // Azul
                        $this->SetTextColor(255, 255, 255); // Blanco
                        $this->Cell(25, 8, utf8_decode('Diagnóstico'), 1, 0, 'L', true); // Celda con borde y relleno
                        $this->SetTextColor(0, 0, 0); // Blanco
                        $this->Cell(30, 8, utf8_decode('Discapacitado'), 1, 0, 'L');
                    }

                    if ($rowF['tomo'] == '') {
                    } else {

                        $this->SetFillColor(93, 173, 226); // Azul
                        $this->SetTextColor(255, 255, 255); // Blanco
                        $this->Cell(24, 8, utf8_decode('N.Tomo'), 1, 0, 'L', true); // Celda con borde y relleno
                        $this->SetTextColor(0, 0, 0); // Blanco
                        $this->Cell(25, 8, utf8_decode($rowF['tomo'] ?? ''), 1, 0, 'L');
                    }


                    if ($rowF['folio'] == '') {
                    } else {

                        $this->SetFillColor(93, 173, 226); // Azul
                        $this->SetTextColor(255, 255, 255); // Blanco
                        $this->Cell(24, 8, utf8_decode('N.Folio'), 1, 0, 'L', true); // Celda con borde y relleno
                        $this->SetTextColor(0, 0, 0); // Blanco
                        $this->Cell(25, 8, utf8_decode($rowF['folio'] ?? ''), 1, 0, 'L');
                    }
                }
            } else {
                $this->Ln(10);

                $this->SetDrawColor(0, 0, 0); // Negro
                $this->SetX(2);
                $this->SetFont('Arial', 'B', 10);
                $this->SetFillColor(255, 255, 255); // Azul
                $this->SetTextColor(0, 0, 0); // Blanco
                $this->Cell(210, 10, utf8_decode('Sin Familiar Asignado'), 1, 0, 'L', true); // Celda con borde y relleno

            }


            $this->Ln(10);
        }

        $this->Output('I', 'ficha_tecnica.pdf');
    }
}
