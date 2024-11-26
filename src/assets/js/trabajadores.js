import {
    validarNombre,
    validarNumeroNumber,
    validarNumeros,
    validarSelectores,
    validarTelefono,
} from "./ajax/inputs.js";

import { AlertSW2 } from "./ajax/alerts.js";
import { enviarDatos, enviarFormulario, obtenerDatos } from "./ajax/formularioAjax.js";

$(function () {
    validarNumeros("#cedula_trabajador", ".span_cedula_empleado", "1");
    validarNombre("#nombreTrabajador", ".span_nombre_empleado", "1");
    validarNombre("#apellidoTrabajador", ".span_apellido_empleado", "1");
    validarTelefono("#telefono", ".span_telefono");
    validarSelectores("#estatus", ".span_estatus");
    validarSelectores("#cargo", ".span_cargo");
    validarSelectores("#departamento", ".span_departamento");
    validarSelectores("#dependencia", ".span_dependencia");
    validarNumeroNumber("#edad", ".span_edad")
    $('#formulario_empleado').on("submit", function (event) {
        event.preventDefault();
        let cedula = $("#cedula_trabajador");
        const formData = new FormData(this);
        function callbackExito(parsedData){
            // console.log(parsedData)
          

        }

        const url = "src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal";
     enviarFormulario(url, formData, callbackExito, true);
    })
})