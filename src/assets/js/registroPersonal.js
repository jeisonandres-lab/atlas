import {
  colocarMeses,
  colocarYear,
  limpiarFormulario,
  valdiarCorreos,
  validarBusquedaCedula,
  validarNombre,
  validarNumeros,
  validarSelectores,
} from "./ajax/inputs.js";

import { enviarFormulario } from "./ajax/formularioAjax.js";

$(function () {
  validarNombre("#primerNombre", ".span_nombre");
  validarNombre("#segundoNombre", ".span_nombre2");
  validarNombre("#primerApellido", ".span_apellido");
  validarNombre("#segundoApellido", ".span_apellido2");
  validarNumeros("#cedula", ".span_cedula");
  validarBusquedaCedula("#cedula", "#img-contener");

  validarSelectores("#civil", ".span_civil");
  validarSelectores("#ano", ".span_ano", "1");
  valdiarCorreos("#correo", ".span_correo");
  colocarYear("#ano", "1900");
  colocarMeses("#meses");
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
  $("#meses").trigger("change");

  validarSelectores("#dia", ".span_dia", "1");

  $("#formulario_registro").on("submit", function (event) {
    event.preventDefault();

    const data = new FormData(this);
    const url = "src/ajax/registroPersonal.php?modulo_personal=registrar";
    // Disable the submit button and show a loading indicator
    $(this).find('button[type="submit"]').prop('disabled', true);
    function callbackExito(){
      $(this).find('button[type="submit"]').prop('disabled', false);
    }
    enviarFormulario(url, data, callbackExito);
  });

  $("#limpiar").on("click", function () {
    limpiarFormulario(
      "#formulario_registro",
      "#dia, #meses, #ano, .span_ano, .span_dia, .span_mes"
    );
  });
});
