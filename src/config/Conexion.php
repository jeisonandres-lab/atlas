<?php
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
        $this->host = Server::DB_SERVER;
        $this->db = Server::DB_NAME;
        $this->user = Server::DB_USER;
        $this->password = Server::DB_PASS;
        $this->charset = Server::DB_CHARSET;
    }

    /**
     * Conecta a la base de datos con optimizaciones para grandes volúmenes
     * @return PDO
     */
    public function conectar()
    {
        try {
            $conexion = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;

            // Aplicar configuraciones optimizadas para grandes volúmenes
            $options = DatabaseOptimization::getPDOOptions();

            $pdo = new PDO($conexion, $this->user, $this->password, $options);

            // Configuraciones adicionales para optimización
            $pdo->exec("SET SESSION sql_mode = 'STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO'");
            $pdo->exec("SET SESSION innodb_lock_wait_timeout = 50");
            $pdo->exec("SET SESSION wait_timeout = 600");
            $pdo->exec("SET SESSION interactive_timeout = 600");

            return $pdo;
        } catch (PDOException $th) {
            Error::captureError();
            print_r('Error connection: ' . $th->getMessage());
        } catch (\Throwable $th) {
            // Capturar cualquier otra excepción
            Error::captureError();
            print_r('Error connection: ' . $th->getMessage());
        }
    }

    /**
     * Valida la conexión a la base de datos
     */
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
}
