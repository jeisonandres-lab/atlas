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
    validarSelectores("#ano", ".span_ano", "1");
    colocarYear("#ano", "1900");
    colocarMeses("#meses");
    validarNumeroNumber("#edad", ".span_edad");

    $("#meses").on("change", function () {
        const year = 2024; // Cambia el año si lo deseas
        const month = $("#meses").val();
        if (month == "") {
            $(this).removeClass("cumplido");
            $(this).addClass("error_input");
            $(".span_mes").removeClass("cumplido_span");
            $(".span_mes").addClass("error_span");
        } else {
            // Eliminar el cero inicial si existe
            const monthWithoutLeadingZero = month.replace(/^0+/, "");
            // Obtener el número de días en el mes seleccionado
            const daysInMonth = new Date(year, monthWithoutLeadingZero, 0).getDate(); // Restamos 1 al mes porque JavaScript cuenta los meses desde 0
            // Generar las opciones de los días
            $("#dia").empty(); // Limpiar las opciones anteriores
            for (let i = 1; i <= daysInMonth; i++) {
                const diaFormateado = i.toString().padStart(2, "0");
                $("#dia").append(
                    '<option value="' + diaFormateado + '">' + diaFormateado + "</option>"
                );
            }
            $(this).removeClass("error_input");
            $(this).addClass("cumplido");
            $(".span_mes").removeClass("error_span");
            $(".span_mes").addClass("cumplido_span");
        }
    });
    $("#meses").trigger("input");
    validarSelectores("#dia", ".span_dia", "1");
    $('#formulario_empleado').on("submit", function (event) {
        event.preventDefault();
        let cedula = $("#cedula_trabajador");
        const formData = new FormData(this);
        function callbackExito(parsedData) {
            // console.log(parsedData)


        }

        const url = "src/ajax/registroPersonal.php?modulo_personal=obtenerDatosPersonal";
        enviarFormulario(url, formData, callbackExito, true);
    })
})