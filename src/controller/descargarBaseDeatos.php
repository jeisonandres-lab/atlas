<?php
require_once '../../vendor/autoload.php';


use App\Atlas\config\Conexion;
use ZipArchive;
use PDO;

class DescargarBaseDeDatos extends Conexion {

    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = $this->conectar();
    }

    public function exportarBaseDeDatosAZIP() {
        $zip = new ZipArchive();
        $filename = "base_de_datos_export_" . date("Y-m-d") . ".zip";

        if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
            exit("No se puede abrir <$filename>\n");
        }

        // Obtener todas las tablas de la base de datos
        $query = $this->db->query("SHOW TABLES");
        $tables = $query->fetchAll(PDO::FETCH_COLUMN);

        $tempFiles = [];

        foreach ($tables as $table) {
            $csvFile = tempnam(sys_get_temp_dir(), $table . "_") . ".csv";
            $output = fopen($csvFile, 'w');

            // Escribir la cabecera BOM para UTF-8
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

            // Obtener los nombres de las columnas
            $query = $this->db->query("SHOW COLUMNS FROM " . $table);
            $columns = $query->fetchAll(PDO::FETCH_COLUMN);
            fputcsv($output, $columns, ';', '"'); // Usar ';' como delimitador

            // Obtener los datos de la tabla
            $query = $this->db->query("SELECT * FROM " . $table);
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                fputcsv($output, $row, ';', '"'); // Usar ';' como delimitador
            }

            fclose($output);

            // Añadir el archivo CSV al archivo ZIP
            $zip->addFile($csvFile, $table . ".csv");
            $tempFiles[] = $csvFile; // Guardar el nombre del archivo temporal para eliminarlo después
        }

        $zip->close();

        // Forzar la descarga del archivo ZIP
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Length: ' . filesize($filename));
        readfile($filename);

        // Eliminar los archivos temporales
        foreach ($tempFiles as $csvFile) {
            unlink($csvFile);
        }

        // Eliminar el archivo ZIP temporal
        unlink($filename);
        exit;
    }

    public function exportarBaseDeDatosASQL() {
        $filename = "base_de_datos_export_" . date("Y-m-d") . ".sql";
        $output = fopen($filename, 'w');

        // Obtener todas las tablas de la base de datos
        $query = $this->db->query("SHOW TABLES");
        $tables = $query->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            // Obtener la estructura de la tabla
            $query = $this->db->query("SHOW CREATE TABLE " . $table);
            $row = $query->fetch(PDO::FETCH_ASSOC);
            fwrite($output, "-- Estructura de la tabla `$table`\n\n");
            fwrite($output, $row['Create Table'] . ";\n\n");

            // Obtener los datos de la tabla
            $query = $this->db->query("SELECT * FROM " . $table);
            $rows = $query->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($rows)) {
                fwrite($output, "-- Datos de la tabla `$table`\n\n");
                foreach ($rows as $row) {
                    $values = array_map([$this->db, 'quote'], array_values($row));
                    fwrite($output, "INSERT INTO `$table` VALUES (" . implode(", ", $values) . ");\n");
                }
                fwrite($output, "\n");
            }
        }

        fclose($output);

        // Forzar la descarga del archivo SQL
        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Content-Length: ' . filesize($filename));
        readfile($filename);

        // Eliminar el archivo SQL temporal
        unlink($filename);
        exit;
    }
}


// Uso
if (isset($_GET['exportar'])) {
    ob_clean(); // Limpiar el búfer de salida
    $descargar = new DescargarBaseDeDatos();
    $descargar->exportarBaseDeDatosASQL();
}
?>