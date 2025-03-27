<?php
//require_once '../../vendor/autoload.php';
namespace App\Atlas\config;

use App\Atlas\config\Server;
use App\Atlas\config\Error;
use PDO;
use PDOException;

class Conexion extends Error
{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

    public function __construct()
    {
        $this->host = server::DB_SERVER;
        $this->db = server::DB_NAME;
        $this->user = server::DB_USER;
        $this->password = server::DB_PASS;
        $this->charset = server::DB_CHARSET;
    }

    public function conectar()
    {
        try {
            $conexion = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $pdo = new PDO($conexion, $this->user, $this->password, $options);
            return $pdo;
        } catch (PDOException $th) {
            error::captureError();
            print_r('Error connection: ' . $th->getMessage());
        } catch (\Throwable $th) {
            // Capturar cualquier otra excepción
            error::captureError();
            print_r('Error connection: ' . $th->getMessage());
        }
    }
    public function validarConexion()
    {
        try {
            $pdo = $this->conectar();
            $query = "SELECT 1 FROM users";
            $stmt = $pdo->query($query);
            $result = $stmt->fetch();

            if ($result) {
                echo "Conexión exitosa a la base de datos y se encontró al menos un registro en la tabla.\n";
            } else {
                echo "Error al ejecutar la consulta o la tabla está vacía.\n";
            }
        } catch (PDOException $e) {
            error::captureError();
            echo "Error de conexión: " . $e->getMessage() . "\n";
            echo "Código del error: " . $e->getCode() . "\n";
            echo "Información del error: " . print_r($e->errorInfo, true);
        }
    }

    public function ejecutarConsulta($consulta, array $parametros = [])
    {
        try {
            $stmt = $this->conectar()->prepare($consulta);
            $stmt->execute($parametros);

            // Si la consulta devuelve resultados, los obtenemos
            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                return [];
            }
        } catch (PDOException $e) {
            error::captureError();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function limpiarCadena($cadena)
    {
        $palabras = [
            "<script>",
            "</script>",
            "<script src",
            "<script type=",
            "SELECT * FROM",
            "SELECT",
            "SELECT",
            "DELETE FROM",
            "INSERT INTO",
            "DROP TABLE",
            "DROP DATABASE",
            "TRUNCATE TABLE",
            "SHOW TABLES",
            "SHOW DATABASES",
            "<?php",
            "?>",
            "--",
            "^",
            "<",
            ">",
            "==",
            "=",
            ";",
            "::"
        ];
        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);
        foreach ($palabras as $palabra) {
            $cadena = str_ireplace($palabra, "", $cadena);
        }
        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);
        return  $cadena;
    }

    protected function verificarDatos($filtro, $cadena)
    {
        $patron = "/^" . $filtro . "$/";
        return !preg_match($patron, $cadena);
    }

    protected function guardarDatos($tabla, $datos)
    {
        $query = "INSERT INTO $tabla (";
        $C = 0;
        foreach ($datos as $clave) {
            if ($C >= 1) {
                $query .= ",";
            }
            $query .= $clave["campo_nombre"];
            $C++;
        }
        $query .= ") VALUES(";
        $C = 0;
        foreach ($datos as $clave) {
            if ($C >= 1) {
                $query .= ",";
            }
            $query .= $clave["campo_marcador"];
            $C++;
        }
        $query .= ")";
        $sql = $this->conectar()->prepare($query);
        foreach ($datos as $clave) {
            $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
        }
        $sql->execute();

        return $sql;
    }

    protected function actualizarDatos($tabla, $datos, $condicion)
    {
        $query = "UPDATE $tabla SET ";

        $C = 0;
        foreach ($datos as $clave) {
            if ($C >= 1) {
                $query .= ",";
            }
            $query .= $clave["campo_nombre"] . " = " . $clave["campo_marcador"];
            $C++;
        }

        $query .= " WHERE " . $condicion["condicion_campo"] . " = " . $condicion["condicion_marcador"];

        $sql = $this->conectar()->prepare($query);

        foreach ($datos as $clave) {
            $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
        }

        $sql->bindParam($condicion["condicion_marcador"], $condicion["condicion_valor"]);

        $sql->execute();

        return $sql;
    }

    /*---------- Funcion eliminar registro ----------*/
    protected function eliminarRegistro($tabla, $campo, $id)
    {
        $sql = $this->conectar()->prepare("DELETE FROM $tabla WHERE $campo=:id");
        $sql->bindParam(":id", $id);
        $sql->execute();

        return $sql;
    }

    /*---------- Funcion seleccionar datos ----------*/
    public function seleccionarDatos($tipo, $tabla, $campo, $id)
    {
        $tipo = $this->limpiarCadena($tipo);
        $tabla = $this->limpiarCadena($tabla);
        $campo = $this->limpiarCadena($campo);
        $id = $this->limpiarCadena($id);

        if ($tipo == "Unico") {
            $sql = $this->conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:ID");
            $sql->bindParam(":ID", $id);
        } elseif ($tipo == "Normal") {
            $sql = $this->conectar()->prepare("SELECT $campo FROM $tabla");
        }
        $sql->execute();

        return $sql;
    }

    /*---------- funcion para obtener la primera columna de una tabala -------------*/
    protected function obtenerPrimeraColumna(string $tabla)
    {
        $consulta = "SELECT COLUMN_NAME
                 FROM INFORMATION_SCHEMA.COLUMNS
                 WHERE TABLE_NAME = ?
                 ORDER BY ORDINAL_POSITION
                 LIMIT 1";

        $resultado = $this->ejecutarConsulta($consulta, [$tabla]);

        if ($resultado && count($resultado) > 0) {
            return $resultado[0]['COLUMN_NAME'];
        }

        return null;
    }
}
