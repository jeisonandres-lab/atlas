<?php
namespace App\Atlas\models\private;
use App\Atlas\config\EjecutarSQL;

// CRUDModel.php
class CRUDModel extends EjecutarSQL {
    protected function registrar($tabla, $datos) {
        return $this->guardarDatos($tabla, $datos);
    }

    protected function actualizar($tabla, $datos, $condicion) {
        return $this->actualizarDatos($tabla, $datos, $condicion);
    }

    protected function eliminar($tabla, $campo, $id) {
        return $this->eliminarRegistro($tabla, $campo, $id);
    }

    protected function seleccionar($tipo, $tabla, $campo, $id){
        return $this->seleccionarDatos($tipo, $tabla, $campo, $id);
    }
}
