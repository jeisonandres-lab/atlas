<?php
namespace Analista\Atlas\config;

require_once '../../vendor/autoload.php';

use Analista\Atlas\config\server;
use PDO;
use PDOException;

class Database{

    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;

   public function __construct(){
      
      $this->host = 'localhost' ;
      $this->db = 'recursos_humanos' ;
      $this->user = 'root';
      $this->password = '';
      $this->charset = 'utf8mb4';
   }

   function connect(){
        try {
            $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $pdo = new PDO($connection, $this->user, $this->password, $options);
            return $pdo;
        } catch (PDOException $e) {
            print_r('Error connection: ' . $e->getMessage());
        }
   }
   public function validateConnection(){
      try {
         $pdo = $this->connect();
         $query = "SELECT 1 FROM personal"; // Reemplaza 'tu_tabla' con el nombre de una tabla existente
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

$constante= new Constantes();
$database = new Database();
$database->validateConnection();
?>