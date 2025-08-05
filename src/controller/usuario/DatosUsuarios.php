<?php

namespace App\Atlas\controller\usuario;

use App\Atlas\config\App;
use App\Atlas\models\public\UsuarioModelPublic;
use App\Atlas\models\private\TablasModel;
use App\Atlas\config\EjecutarSQL;
use Exception;

class DatosUsuarios
{
    private $auditoriaController;
    private $app;
    private $tablas;
    private $usuarioPublico;
    private $ejecutarSQL;

    public function __construct()
    {
        $this->app = new App();
        $this->tablas = new TablasModel();
        $this->usuarioPublico = new UsuarioModelPublic();
        $this->ejecutarSQL = new EjecutarSQL();
    }

    public function datosUsuariosBasicos()
    {
        // Verificar si es una petición AJAX (más flexible)
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                   strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        // También aceptar peticiones POST directas para DataTables
        $isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
        
        if ($isAjax || $isPost) {
            try {
                $data_json['data'] = [];
                $tabla = 'users us INNER JOIN rol ON us.idRol = rol.id_rol
                            INNER JOIN datosempleados dte ON us.idEmpleado = dte.id_empleados
                            INNER JOIN datospersonales dtp ON dte.idPersonal = dtp.id_personal
                            INNER JOIN cargo cg ON dte.idCargo = cg.id_cargo';
                $selectoresCantidad = 'COUNT(us.id_user) as cantidad';
                $datosBuscar = [];
                $campoOrden = 'us.id_user';
                $selectores = 'us.id_user, us.enUso, us.idRol, us.nameUser, us.activo, dtp.primerNombre, dtp.primerApellido, dtp.cedula, rol.rol, cg.cargo ';
                $conditions = [];
                $conditionParams = [];

                // Verifica si las claves existen antes de usarlas
                $draw = isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0;
                $start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;
                $length = isset($_REQUEST['length']) ? intval($_REQUEST['length']) : 10; // Valor por defecto

                // Verifica si la clave 'search' existe y luego si 'value' existe dentro de ella
                $searchValue = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

                // Obtener la cantidad de los datos de la tabla
                $cantidadRegistro = $this->tablas->getCantidadRegistros($tabla, $selectoresCantidad, $conditions, $conditionParams);
                
                // Obtener los datos de la tabla
                $personal = $this->tablas->getTodoDatosPersonal($selectores, $tabla, $start, $length, $searchValue, $datosBuscar, $campoOrden, $conditions, $conditionParams, $ordenTabla = 'ASC');

                // Verificar si se obtuvieron datos
                if ($personal === false || empty($personal)) {
                    error_log("No se obtuvieron datos de la tabla personal");
                    $personal = []; // Asegurar que sea un array vacío
                }

                // Recorrer datos de la tabla
                foreach ($personal as $row) {
                    $data_json['data'][] = [
                        '0' => $row['enUso'],
                        '1' => $row['nameUser'],
                        '2' => $row['rol'],
                        '3' => $row['activo'],
                        '4' => "
                        <div class='d-flex content-user-data'>
                            <img src='./src/global/photos/{$row['cedula']}.png' alt='Imagen no disponible' class='img-userEmpleado rounded-circle me-2'>
                            <div class='d-flex flex-column'>
                                <span class='nameUser'> {$row['primerNombre']} {$row['primerApellido']}</span>
                                <span class='nameUser'> {$row['cargo']}</span>
                            </div>
                        </div>",
                    ];
                }

                // Devolver la respuesta a DataTables
                $response = array(
                    "draw" => $draw,
                    "recordsTotal" => $cantidadRegistro[0]['cantidad'] ?? 0,
                    "recordsFiltered" => $cantidadRegistro[0]['cantidad'] ?? 0,
                    "data" => $data_json['data']
                );
                
                header('Content-Type: application/json');
                echo json_encode($response);
                
            } catch (Exception $e) {
                error_log("Error en datosUsuariosBasicos: " . $e->getMessage());
                header('Content-Type: application/json');
                echo json_encode([
                    "draw" => isset($_REQUEST['draw']) ? intval($_REQUEST['draw']) : 0,
                    "recordsTotal" => 0,
                    "recordsFiltered" => 0,
                    "data" => [],
                    "error" => "Error al obtener datos: " . $e->getMessage()
                ]);
            }
        } else {
            // Enviar una respuesta de error si no es una petición válida
            http_response_code(403);
            echo json_encode(['error' => 'Acceso denegado.']);
        }
    }
}
