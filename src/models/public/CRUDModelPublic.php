<?php

namespace App\Atlas\models\public;

use App\Atlas\models\private\CRUDModel;

class CRUDModelPublic extends CRUDModel {
    public function getRegistrar($tabla, $datos) {
        return $this->registrar($tabla, $datos);
    }

    public function getActualizar($tabla, $datos, $condicion) {
        return $this->actualizar($tabla, $datos, $condicion);
    }

    public function getEliminar($tabla, $campo, $id) {
        return $this->eliminar($tabla, $campo, $id);
    }
}