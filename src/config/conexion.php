<?php
//require_once '../../vendor/autoload.php';
namespace App\Atlas\config;

use App\Atlas\config\Server;
use PDO;
use PDOException;

class Conexion
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

    function conectar()
    {
        try {
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $pdo = new PDO($connection, $this->user, $this->password, $options);
            return $pdo;
        } catch (PDOException $th) {
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
            echo "Error de conexión: " . $e->getMessage() . "\n";
            echo "Código del error: " . $e->getCode() . "\n";
            echo "Información del error: " . print_r($e->errorInfo, true);
        }
    }
}


